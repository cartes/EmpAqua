<?php

namespace App\Http\Controllers;

use App\Enums\Membership;
use App\Helpers\Helper;
use App\Http\Requests\BusinessLoginRequest;
use App\Http\Requests\BusinessProfileRequest;
use App\Http\Requests\BusinessRegisterRequest;
use App\Models\Business;
use App\Models\BusinessMeta;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class BusinessController extends Controller
{
    public function index(): View
    {
        return view('business.index');
    }

    public function login(BusinessLoginRequest $request): RedirectResponse
    {
        $business = Business::where('email_user', $request->email)
            ->with('business_meta', 'roles')
            ->first();

        if (! $business) {
            return back()->with('message', ['warning', 'Email no está registrado como empresa']);
        }

        if (! Hash::check($request->password, $business->password)) {
            return back()->with('message', ['danger', 'Contraseña no coincide, inténtelo de nuevo']);
        }

        // Empresa sin datos de negocio: debe completarlos antes de operar.
        if (! $business->business_meta) {
            session([
                'id' => $business->id,
                'name' => $business->firstname . ' ' . $business->surname,
                'role' => 'business',
            ]);

            return redirect()->route('business.profile')
                ->with('message', ['secondary', 'Ingrese los datos de su empresa o negocio']);
        }

        $roleId = $business->roles?->role ?? (string) Membership::Free->value;
        $membership = Membership::fromSession($roleId);
        $daysLeft = null;
        $expired = false;

        if ($membership?->durationDays() !== null) {
            $expiresAt = Carbon::parse($business->roles->updated_at)->addDays($membership->durationDays());

            if ($expiresAt->isPast()) {
                // La membresía venció: la empresa vuelve al plan gratuito.
                $business->roles->update(['role' => (string) Membership::Free->value]);
                $roleId = (string) Membership::Free->value;
                $membership = Membership::Free;
                $expired = true;
            } else {
                $daysLeft = (int) abs($expiresAt->diffInDays(now()));
            }
        }

        session([
            'id' => $business->id,
            'name' => $business->business_meta->business_name,
            'role' => $membership?->sessionRole() ?? 'business',
            'role_id' => $roleId,
            ...($daysLeft !== null ? ['exp_role' => $daysLeft] : []),
        ]);

        if ($business->migrated) {
            return redirect()->route('business.passform');
        }

        $redirect = $request->redirect;
        $target = ($redirect && Route::has($redirect)) ? $redirect : 'offer.admin';

        return redirect()->route($target)->with(
            $expired ? ['message' => ['warning', 'Tu membresía venció, tu plan volvió a Gratis']] : []
        );
    }

    public function profileIndex(): View
    {
        $business = Business::with(['business_meta', 'offers'])->findOrFail(session('id'));

        return view('business.profile', [
            'candidates' => (int) $business->offers->sum('candidates_count'),
            'business' => $business,
        ]);
    }

    public function register(BusinessRegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $rut = str_replace('.', '', $data['rut_user']);
        if (substr($rut, -2, 1) !== '-') {
            $rut = substr($rut, 0, -1) . '-' . substr($rut, -1);
        }

        $business = DB::transaction(function () use ($data, $rut) {
            $business = Business::create([
                'rut_user' => $rut,
                'firstname' => $data['firstname'],
                'surname' => $data['surname'],
                'position' => $data['position'],
                'email_user' => $data['email_business'],
                'phone_user' => $data['phone_business'],
                'password' => Hash::make($data['passbusiness']),
            ]);

            BusinessMeta::create(['id_business' => $business->id]);
            Role::create(['id_business' => $business->id, 'role' => Membership::Free->value]);

            return $business;
        });

        session([
            'id' => $business->id,
            'name' => $business->firstname . ' ' . $business->surname,
            'role' => 'business',
        ]);

        return redirect()->route('business.edit')->with('message', ['success', 'Registro exitoso']);
    }

    public function updateProfile(BusinessProfileRequest $request): RedirectResponse
    {
        $id = session('id');

        $meta = $request->only(array_diff((new BusinessMeta)->getFillable(), ['id_business', 'picture', 'path']));
        $meta['rut_business'] = preg_replace('/\s+/', '', (string) $request->rut_business);

        if ($request->hasFile('picture')) {
            $meta['path'] = Helper::uploadFile('picture', 'business');
            $meta['picture'] = $request->file('picture')->getClientOriginalName();
        }

        BusinessMeta::updateOrCreate(['id_business' => $id], $meta);

        Business::whereKey($id)->update($request->only([
            'rut_user', 'firstname', 'surname', 'email_user', 'position', 'phone_user',
        ]));

        return redirect()->route('business.profile')->with('message', ['success', 'Perfil editado correctamente']);
    }

    public function file(int $id): View
    {
        $business = Business::withCount('offers')->with('business_meta', 'offers')->findOrFail($id);

        return view('business.file', compact('business'));
    }

    public function edit(): View
    {
        $business = Business::with(['business_meta', 'offers'])->find(session('id'));

        return view('business.edit', compact('business'));
    }

    public function change_passw(Request $request): RedirectResponse
    {
        $data = $request->validate(['password' => ['required', 'min:6', 'confirmed']]);

        Business::whereKey(session('id'))->update([
            'migrated' => false,
            'password' => Hash::make($data['password']),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function list(): View
    {
        return view('business.roles', ['business' => $this->businessWithRoles()->paginate(25)]);
    }

    public function list_membership(Request $request): View
    {
        $request->validate(['membership' => ['nullable', 'integer']]);

        $business = $this->businessWithRoles()
            ->when($request->filled('membership'), fn ($query) => $query->whereHas(
                'roles',
                fn ($roles) => $roles->where('role', $request->membership)
            ))
            ->paginate(25)
            ->withQueryString();

        return view('business.roles', compact('business'));
    }

    public function ajax(Request $request): JsonResponse
    {
        $role = $request->role;

        $rows = DB::table('aquabe_business')
            ->where('aquabe_business.id', '!=', session('id'))
            ->leftJoin('aquabe_business_meta', 'aquabe_business.id', '=', 'aquabe_business_meta.id_business')
            ->leftJoin('aquabe_roles', 'aquabe_business.id', '=', 'aquabe_roles.id_business')
            ->when($role !== null && $role !== '' && $role !== '-1', fn ($query) => $query->where('aquabe_roles.role', $role))
            ->select(
                'aquabe_business.id',
                'aquabe_business_meta.rut_business',
                'aquabe_business.rut_user',
                'aquabe_business.firstname',
                'aquabe_business.surname',
                'aquabe_business_meta.business_name',
                'aquabe_business.email_user',
                'aquabe_roles.role',
                'aquabe_roles.updated_at'
            )
            ->get();

        return DataTables::of($rows)
            ->addColumn('updated_at', fn ($row) => $this->expirationCell($row))
            ->addColumn('action', fn ($row) => $this->roleFormCell($row))
            ->rawColumns(['updated_at', 'action'])
            ->make(true);
    }

    public function show_superadmin(int $id): View
    {
        abort_unless(Membership::fromSession(session('role_id')) === Membership::Admin, 403, 'No autorizado');

        $business = Business::with('business_meta')->findOrFail($id);

        // Postulaciones recibidas en los últimos 7 días por sus ofertas.
        $candidates = $business->offers()
            ->where('created_at', '>=', now()->subDays(7))
            ->withCount('candidates')
            ->get()
            ->sum('candidates_count');

        return view('business.show_superadmin', compact('business', 'candidates'));
    }

    private function businessWithRoles()
    {
        return Business::where('id', '!=', session('id'))
            ->select('id', 'rut_user', 'firstname', 'surname', 'email_user')
            ->with(['business_meta', 'roles']);
    }

    private function expirationCell(object $row): string
    {
        $membership = Membership::fromSession($row->role);
        $days = $membership?->durationDays();

        if ($days === null) {
            return '<div class="p-3 text-white bg-secondary">No aplica</div>';
        }

        $expiresAt = Carbon::parse($row->updated_at)->addDays($days);
        $text = ($expiresAt->isPast() ? 'Venció hace ' : 'Vencerá en ') . (int) abs($expiresAt->diffInDays(now()));

        return '<div class="p-3 rounded text-white bg-secondary">' . e($text) . ' Días</div>';
    }

    private function roleFormCell(object $row): string
    {
        $current = Membership::fromSession($row->role) ?? Membership::Free;

        $options = collect(Membership::assignable())
            ->map(fn (Membership $plan) => sprintf(
                '<option value="%d"%s>%s</option>',
                $plan->value,
                $plan === $current ? ' selected' : '',
                e($plan->label())
            ))
            ->implode('');

        return '<form class="form-group" action="' . e(route('role.edit', ['id' => $row->id])) . '" method="post">'
            . csrf_field() . method_field('PUT')
            . '<select class="d-inline-block form-control" name="role[]">' . $options . '</select>'
            . '<input type="submit" class="d-inline-block ml-2 btn btn-primary" value="Cambiar"/>'
            . '</form>';
    }
}
