c
<?php

namespace App\Http\Controllers;

use App\Business;
use App\BusinessMeta;
use App\Helpers\Helper;
use App\Http\Requests\BusinessLoginRequest;
use App\Http\Requests\BusinessProfileRequest;
use App\Http\Requests\BusinessRegisterRequest;
use App\Offers;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BusinessController extends Controller
{
    public function index()
    {
        return view('business.index');
    }

    public function login(BusinessLoginRequest $request)
    {
        $how_much = null;
        $business = Business::where('email_user', $request->email)
            ->with('business_meta', 'roles')
            ->withCount('offers')
            ->first();



        if ($business) {
            if (Hash::check($request->password, $business->password)) {

                if ($business->business_meta) {
                    if (!empty($business->roles)) {
                        $role_id = $business->roles->role;
                        $exp_role = Carbon::now();
                        switch ($business->roles->role) {
                            case '0':
                                $role = 'administrador';
                                break;
                            case '10':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(31);
                                break;
                            case '11':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(31);
                                break;
                            case '12':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(90);
                                break;
                            case '13':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(180);
                                break;
                            case '14':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(270);
                                break;
                            case '15':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(365);
                                break;
                            case '16':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(365);
                                break;
                            case '17':
                                $role = 'business';
                                $exp_role = Carbon::parse($business->roles->updated_at)->addDays(365);
                                break;
                            case '90':
                                $role = 'business';
                                break;
                            default:
                                $role = 'business';
                                break;
                        }
                        if ($role_id != '0' && $role_id != '90') {
                            $how_much = (int) abs($exp_role->diffInDays(Carbon::now()));
                            $greater = $exp_role->gt(Carbon::now());
                            if (!$greater) {
                                $business_no_featured = Role::where('id_business', $business->id)->update(['role' => '90']);
                                return redirect()->route('logout');
                            }
                        } else {
                            $how_much = null;
                        }
                    } else {
                        $role_id = '90';
                        $role = "business";
                    }

                    if (is_null($how_much)) {
                        session([
                            'id' => $business->id,
                            'name' => $business->business_meta->business_name,
                            'role' => $role,
                            'role_id' => $role_id,
                        ]);

                    } else {
                        session([
                            'id' => $business->id,
                            'name' => $business->business_meta->business_name,
                            'role' => $role,
                            'role_id' => $role_id,
                            'exp_role' => $how_much
                        ]);
                    }

                    if ($business->migrated) {
                        return redirect(route('business.passform'));
                    }


                    if (!is_null($request->redirect)) {
                        return redirect()->route($request->redirect);
                    } else {
                        return redirect()->route('offer.admin');
                    }
                } else {
                    session([
                        'id' => $business->id,
                        'name' => $business->firstname . ' ' . $business->surname,
                        'role' => 'business'
                    ]);
                    return redirect()->route('business.profile')->with('message', ['secondary', 'Ingrese los datos de su empresa o negocio']);
                }
            } else {
                return back()->with('message', ['danger', 'Contraseña no coincide, inténtelo de nuevo']);
            }
        } else {
            return back()->with('message', ['warning', 'Email no está registrado como empresa']);
        }
    }

    public function profileIndex(Request $request)
    {
        $id = session()->get('id');
        $business = Business::where('id', $id)
            ->with(['business_meta', 'offers'])
            ->first();

        $candidates_number = 0;
        foreach ($business->offers as $offer) {
            $candidates_number += (int) $offer->candidates_count;
        }

        return view('business.profile')
            ->with([
                'candidates' => $candidates_number,
                'business' => $business
            ]);
    }

    public function register(BusinessRegisterRequest $request)
    {
        $pass = Hash::make($request->passbusiness);
        $request->merge(['email_user' => $request->email_business]);
        $request->merge(['phone_user' => $request->phone_business]);
        $request->merge(['password' => $pass]);
        $rut = str_replace('.', '', $request->rut_user);

        if (substr($rut, -2, 1) !== '-') {
            $rut = substr($rut, 0, -1) . '-' . substr($rut, -1, 1);
        }

        $request->merge(['rut_user' => $rut]);

        $business = Business::create($request->input());
        BusinessMeta::create([
            "id_business" => $business->id
        ]);
        Role::create([
            "id_business" => $business->id,
            "role" => 90
        ]);

        session([
            'id' => $business->id,
            'name' => $business->firstname . ' ' . $business->surname,
            'role' => 'business'
        ]);

        return redirect()->route("business.edit")->with('message', ['success', 'Registro exitoso']);
    }

    public function updateProfile(BusinessProfileRequest $request)
    {
        $id = session()->get('id');

        if ($request->hasFile('picture')) {
            $path = Helper::uploadFile('picture', 'business');
            $request->merge(['path' => basename($path)]);
            $request->merge(['picture' => $request->file('picture')->getClientOriginalName()]);
        }

        $rutbusiness = preg_replace('/\s+/', '', $request->rut_business);
        $request->merge(['rut_business' => $rutbusiness]);
        BusinessMeta::updateOrCreate(['id_business' => $id], $request->input());
        Business::whereId($id)->update([
            'rut_user' => $request->rut_user,
            'firstname' => $request->firstname,
            'surname' => $request->surname,
            'email_user' => $request->email_user,
            'position' => $request->position,
            'phone_user' => $request->phone_user
        ]);

        return redirect()->route('business.profile')->with('message', ['success', 'Perfil editado correctamente']);
    }

    public function file($id)
    {
        $business = Business::whereId($id)->withCount('offers')->with('business_meta', 'offers')->first();

        return view('business.file', compact('business'));
    }

    public function edit()
    {
        $id = session()->get('id');
        $business = Business::where('id', $id)
            ->with(['business_meta', 'offers'])
            ->first();

        return view("business.edit")->with(["business" => $business]);
    }

    public function change_passw(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate);
        }
        $id = session()->get('id');
        $passw = Hash::make($request->password);

        Business::whereId($id)->update([
            'migrated' => false,
            'password' => $passw
        ]);
        session()->flush();

        return redirect(route('home'));
    }

    public function list()
    {
        $business = Business::where('id', '!=', session()->get('id'))
            ->select('id', 'rut_user', 'firstname', 'surname', 'email_user')
            ->with(['business_meta', 'roles'])
            ->paginate(25);

        return view('business.roles')->with(['business' => $business]);
    }

    public function list_membership(Request $request)
    {
        $role = $request->membership;

        $byRole = Role::where('role', '10')->with(['business', 'business_meta'])->get();

        $business = Business::select('id', 'rut_user', 'firstname', 'surname', 'email_user')
            ->with([
                'roles' => function ($query) {
                    $query->where('role', 'like', '%10%');
                },
                'business_meta',
            ])
            ->get();

        dd($byRole);

        return view('business.roles')->with(['business' => $business]);

    }

    public function ajax(Request $request)
    {
        $num_rile = $request->role;

        if ($num_rile == '-1' || is_null($num_rile) || $num_rile === '') {
            $role = DB::table('aquabe_business')->where('aquabe_business.id', '!=', session()->get('id'))
                ->leftJoin('aquabe_business_meta', 'aquabe_business.id', '=', 'aquabe_business_meta.id_business')
                ->leftJoin('aquabe_roles', 'aquabe_business.id', '=', 'aquabe_roles.id_business')
                ->select('aquabe_business.id', 'aquabe_business_meta.rut_business', 'aquabe_business.rut_user', 'aquabe_business.firstname', 'aquabe_business.surname', 'aquabe_business_meta.business_name', 'aquabe_business.email_user', 'aquabe_roles.role', 'aquabe_roles.updated_at')
                ->get();

        } else {
            $role = DB::table('aquabe_business')->where('aquabe_business.id', '!=', session()->get('id'))
                ->leftJoin('aquabe_business_meta', 'aquabe_business.id', '=', 'aquabe_business_meta.id_business')
                ->leftJoin('aquabe_roles', function ($join) use ($num_rile) {
                    $join->on('aquabe_business.id', '=', 'aquabe_roles.id_business');
                })
                ->where('aquabe_roles.role', 'like', $num_rile)
                ->select('aquabe_business.id', 'aquabe_business_meta.rut_business', 'aquabe_business.rut_user', 'aquabe_business.firstname', 'aquabe_business.surname', 'aquabe_business_meta.business_name', 'aquabe_business.email_user', 'aquabe_roles.role', 'aquabe_roles.updated_at')
                ->get();

        }

        return DataTables::of($role)
            ->addColumn('updated_at', function ($row) {
                $expiracion = '';
                $upd = Carbon::parse($row->updated_at);
                $diff = (int) abs(Carbon::parse($row->updated_at)->diffInDays(Carbon::now()));
                $role_row = $row->role;
                if (is_null($role_row) || $role_row == '90' || $role_row == '0') {
                    $txt = '<div class="p-3 text-white bg-secondary">No aplica</div>';
                } else {
                    if ($role_row == '10') {
                        $expiracion = Carbon::parse($row->updated_at)->addDays(31);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '11') {
                        $expiracion = Carbon::parse($row->updated_at)->addDays(31);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '16') {
                        $expiracion = Carbon::parse($row->updated_at)->addDays(31);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '12') {
                        $expiracion = Carbon::parse($row->updated_at)->addMonths(3);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '13') {
                        $expiracion = Carbon::parse($row->updated_at)->addMonths(6);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '14') {
                        $expiracion = Carbon::parse($row->updated_at)->addMonths(9);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '15') {
                        $expiracion = Carbon::parse($row->updated_at)->addMonths(12);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '16') {
                        $expiracion = Carbon::parse($row->updated_at)->addMonths(12);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    } elseif ($role_row == '17') {
                        $expiracion = Carbon::parse($row->updated_at)->addMonths(12);
                        $diff = $expiracion < Carbon::now() ? "Venció hace " : "Vencerá en ";
                        $diff .= (int) abs($expiracion->diffInDays(Carbon::now()));
                    }
                    $txt = '<div class="p-3 rounded text-white bg-secondary">' . $diff . ' Días</div>';
                }
                return $txt;
            })
            ->addColumn('action', function ($row) {
                $action = '<form class="form-group" action="' . route('role.edit', ["id" => $row->id]) . '" method="post">';
                $action .= '<input type="hidden" name="_token" value="' . csrf_token() . '" />';
                $action .= '<input type="hidden" name="_method" value="PUT" />';
                $action .= '<select class="d-inline-block form-control" name="role[]">';
                $action .= '<option  value="90"';
                $action .= ($row->role == '90' || is_null($row->role)) ? ' selected' : '';
                $action .= '>Gratis</option>';
                $action .= '<option  value="10"';
                $action .= ($row->role == '10') ? ' selected' : '';
                $action .= '>Básico</option>';
                $action .= '<option value="11"';
                $action .= ($row->role == '11') ? ' selected' : '';
                $action .= '>Premium</option>';
                $action .= '<option value="16"';
                $action .= ($row->role == '16') ? ' selected' : '';
                $action .= '>Gold</option>';
                $action .= '<option value="12"';
                $action .= ($row->role == '12') ? ' selected' : '';
                $action .= '>Corporativo A1</option>';
                $action .= '<option value="13"';
                $action .= ($row->role == '13') ? ' selected' : '';
                $action .= '>Corporativo A2</option>';
                $action .= '<option value="14"';
                $action .= ($row->role == '14') ? ' selected' : '';
                $action .= '>Corporativo A3</option>';
                $action .= '<option value="15"';
                $action .= ($row->role == '15') ? ' selected' : '';
                $action .= '>Corporativo A4</option>';
                $action .= '<option value="16"';
                $action .= ($row->role == '16') ? ' selected' : '';
                $action .= '>Corporativo A5</option>';
                $action .= '<option value="17"';
                $action .= ($row->role == '17') ? ' selected' : '';
                $action .= '>Corporativo Plus</option>';
                $action .= '</select>';
                $action .= '<input type="submit" class="d-inline-block ml-2 btn btn-primary" value="Cambiar"/>';
                $action .= '</form>';

                return $action;
            })->rawColumns(['updated_at', 'action'])
            ->make(true);
    }

    public function show_superadmin($id)
    {
        // Verifica que el usuario sea superadmin
        if (session()->get('role_id') !== '0') {
            abort(403, 'No autorizado');
        }

        // Busca el negocio por id con su metadato
        $business = Business::with('business_meta')->findOrFail($id);

        // Calcula la cantidad de postulaciones en los últimos 7 días a sus ofertas
        $candidates = $business->offers()
            ->where('created_at', '>=', now()->subDays(7))
            ->withCount('candidates')
            ->get()
            ->sum('candidates_count');

        // Retorna la vista solo lectura para superadmin
        return view('business.show_superadmin', [
            'business' => $business,
            'candidates' => $candidates,
        ]);

    }
}
