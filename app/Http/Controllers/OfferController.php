<?php

namespace App\Http\Controllers;

use App\Enums\Membership;
use App\Http\Requests\CreateOfferRequest;
use App\Http\Requests\OfferEditRequest;
use App\Models\Business;
use App\Models\CandidateStatus;
use App\Models\Candidates;
use App\Models\Category;
use App\Models\Offers;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class OfferController extends Controller
{
    /** Campos de la oferta que puede editar la empresa desde los formularios. */
    private const EDITABLE = [
        'title', 'category_id', 'position', 'comune', 'handicapped', 'description',
        'area', 'experience', 'requirements', 'vacancy',
    ];

    /*
    |--------------------------------------------------------------------------
    | Panel de la empresa
    |--------------------------------------------------------------------------
    */

    public function index(): View|RedirectResponse
    {
        $id = session('id');

        if (! $id) {
            return redirect()->route('home');
        }

        $membership = Membership::fromSession(session('role_id'));
        $featuredAllowed = $membership?->featuredAds() ?? 0;

        session()->put('ads', $featuredAllowed - $this->countFeatured($id));

        $offers = Offers::where('id_business', $id)
            ->select(['id', 'id_business', 'title', 'visit', 'featured', 'published', 'slug', 'created_at', 'expirated_at'])
            ->whereDate('expirated_at', '>=', now())
            ->with(['businessMeta', 'Benefits', 'candidates', 'User'])
            ->orderByDesc('created_at')
            ->paginate(25);

        $expired = Offers::where('id_business', $id)
            ->whereDate('expirated_at', '<', now())
            ->orderBy('created_at')
            ->paginate(25);

        $business = Business::with('business_meta')->withCount('offers')->find($id);

        return view('offers.index', [
            'expired' => $expired,
            'business' => $business,
            'offers' => $offers,
            'candidates' => $offers->getCollection()->flatMap(fn (Offers $offer) => $offer->User)->groupBy('id'),
            'role' => $membership?->label() ?? '',
            'featured' => $featuredAllowed,
        ]);
    }

    public function detail(Offers $offer): View|RedirectResponse
    {
        if ($offer->id_business != session('id')) {
            return redirect()->route('offer.admin')
                ->with('message', ['danger', 'No estas autorizado para administrar esta oferta']);
        }

        return view('offers.detail', [
            'offer' => $offer,
            'business' => Business::with('business_meta')->find($offer->id_business),
            'benefits' => $offer->Benefits,
            'categories' => Category::all(),
        ]);
    }

    public function create(CreateOfferRequest $request): RedirectResponse
    {
        $salaryOption = $request->input('salary_opt');

        $salary = match ($salaryOption) {
            '0' => 0,
            '1' => $request->input('salary'),
            default => $request->input('salaryMin') . ' - ' . $request->input('salaryMax'),
        };

        $offer = Offers::create([
            ...$request->only(self::EDITABLE),
            'id_business' => session('id'),
            'sub_area' => '',
            'salary' => $salary,
            'salary_array' => $salaryOption,
            'status' => $request->input('status') === 'on',
            'slug' => $this->uniqueSlug($request->input('title')),
            'expirated_at' => now()->addDays(30),
        ]);

        $this->addBenefits($offer, $request->input('benefits', []));

        return redirect()->route('offer.show', $offer->slug)
            ->with('message', ['success', 'Publicación de nueva oferta exitosa']);
    }

    public function store(OfferEditRequest $request, Offers $offer): RedirectResponse
    {
        if (session('id') != $offer->id_business) {
            return redirect()->route('offer.admin')
                ->with('message', ['danger', 'No estás autorizado para corregir estos datos']);
        }

        if (is_array($request->benefits)) {
            $offer->Benefits()->delete();
            $this->addBenefits($offer, $request->benefits);
        }

        $offer->fill([
            ...$request->only(self::EDITABLE),
            'salary' => (int) str_replace('.', '', (string) $request->salary),
            'status' => $request->input('status') === 'on',
        ])->save();

        if ($request->filled('benefit')) {
            $offer->Benefits()->create(['benefit' => $request->benefit]);
        }

        return back()->with('message', ['success', 'Datos actualizados']);
    }

    public function unpublish(Offers $offer): RedirectResponse
    {
        $this->authorizeOwner($offer);
        $offer->update(['published' => 0]);

        return back()->with('message', ['success', 'La oferta se ocultó correctamente']);
    }

    public function republishState(Offers $offer): RedirectResponse
    {
        $this->authorizeOwner($offer);
        $offer->update(['published' => 1]);

        return back()->with('message', ['success', 'La oferta se republicó correctamente']);
    }

    public function destroy(Offers $offer): RedirectResponse
    {
        $this->authorizeOwner($offer);
        $offer->delete();

        return back()->with('message', ['success', 'Oferta eliminada correctamente']);
    }

    public function republish(Offers $offer): RedirectResponse
    {
        $this->authorizeOwner($offer);

        $offer->candidates()->delete();
        $offer->forceFill([
            'expirated_at' => now()->addDays(30),
            'created_at' => now(),
        ])->save();

        return redirect()->route('offer.admin');
    }

    public function featured(Request $request): JsonResponse
    {
        $request->validate(['id' => ['required', 'integer'], 'feature' => ['required']]);

        $businessId = session('id');
        $feature = $request->boolean('feature');

        $allowed = (Membership::fromSession(session('role_id'))?->featuredAds()) ?? 0;
        $count = $this->countFeatured($businessId) - ($feature ? 0 : 1);

        $offer = Offers::where('id', $request->id)->where('id_business', $businessId)->firstOrFail();

        if ($allowed === 0 || $count >= $allowed) {
            Offers::where('id_business', $businessId)->where('featured', true)->update(['featured' => false]);

            $message = 'Excedió o no tiene acceso a avisos destacados';

            session()->put('ads', $allowed);
            session()->put('message', ['danger', $message]);

            return response()->json(['code' => 401, 'message' => $message], 400);
        }

        $offer->update([
            'featured' => $feature,
            'expirated_at' => Carbon::parse($offer->created_at)->addDays(45),
        ]);

        $message = $feature
            ? "La oferta de trabajo {$offer->id} se ha destacado"
            : "La oferta de trabajo {$offer->id} se ha dejado normal";

        session()->put('ads', $allowed - $this->countFeatured($businessId));
        session()->put('message', ['success', $message]);

        return response()->json(['code' => 200, 'message' => $message]);
    }

    /*
    |--------------------------------------------------------------------------
    | Candidatos de la empresa
    |--------------------------------------------------------------------------
    */

    public function candidates(Offers $offer): View
    {
        $this->authorizeOwner($offer);

        $limit = Membership::fromSession(session('role_id'))?->candidateLimit() ?? 3;

        $candidates = Candidates::where('id_offer', $offer->id)
            ->take($limit)
            ->orderByDesc('favorite')
            ->with([
                'user', 'user.userMeta', 'user.userEducation',
                'candidateStatus' => fn ($query) => $query->where('offer_id', $offer->id),
            ])
            ->get();

        return view('business.candidates', compact('offer', 'candidates'));
    }

    public function updateCandidateStatus(Request $request): JsonResponse
    {
        $data = $request->validate([
            'candidate_id' => ['required', 'exists:aquabe_users,id'],
            'offer_id' => ['required', 'exists:aquabe_offers,id'],
            'status' => ['required', 'string'],
        ]);

        $this->authorizeOwner(Offers::findOrFail($data['offer_id']));

        $status = CandidateStatus::updateOrCreate(
            ['candidate_id' => $data['candidate_id'], 'offer_id' => $data['offer_id']],
            ['status' => $data['status']]
        );

        return response()->json(['success' => true, 'status' => $status]);
    }

    public function addFavoriteCandidate(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 400);

        $this->authorizeOwner(Offers::findOrFail($request->input('offer')));

        $offerId = $request->input('offer');
        $userId = $request->input('user');

        $candidate = Candidates::where('id_offer', $offerId)
            ->where('id_user', $userId)
            ->firstOrFail();

        $favorite = ! $candidate->favorite;

        $candidate->update(['favorite' => $favorite]);

        return response()->json(['favorite' => $favorite]);
    }

    public function all_candidates(Offers $offer): View
    {
        $this->authorizeOwner($offer);

        $candidates = User::with('userMeta', 'userEducation')->get();

        return view('business.allcandidates', compact('offer', 'candidates'));
    }

    public function all_candidates_data(Request $request)
    {
        $this->authorizeBusinessSession();

        // Agrega al candidato seleccionado como postulante de la oferta.
        if ($request->has('idCandidate') && $request->has('offerId')) {
            $offer = Offers::find($request->offerId);

            if ($offer && User::whereKey($request->idCandidate)->exists()) {
                $this->authorizeOwner($offer);

                Candidates::firstOrCreate(
                    ['id_offer' => $offer->id, 'id_user' => $request->idCandidate],
                    ['status' => 0]
                );
            }
        }

        $users = User::orderByDesc('created_at')
            ->whereNotNull('nacionality')
            ->whereNotNull('marital_status')
            ->whereDoesntHave('offers')
            ->with(['userMeta', 'userEducation' => fn ($query) => $query->whereNotNull('studies')])
            ->when($request->filled('studies'), fn ($q) => $q->whereHas(
                'userEducation',
                fn ($e) => $e->whereIn('studies', (array) $request->studies)
            ))
            ->when($request->filled('region'), fn ($q) => $q->whereHas(
                'userMeta',
                fn ($m) => $m->whereIn('state', (array) $request->region)
            ))
            ->when($request->filled('ageRange'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    foreach ((array) $request->ageRange as $range) {
                        [$min, $max] = array_map('intval', explode('-', $range) + [1 => 0]);

                        $this->whereBirthdayBetween($query, now()->subYears($max), now()->subYears($min), true);
                    }
                });
            })
            ->when($request->filled('customAgeMin') && $request->filled('customAgeMax'), function ($q) use ($request) {
                $min = (int) $request->customAgeMin;
                $max = (int) $request->customAgeMax;

                if ($min > $max) {
                    [$min, $max] = [$max, $min];
                }

                $this->whereBirthdayBetween($q, now()->subYears($max), now()->subYears($min));
            })
            ->when($request->filled('gender'), fn ($q) => $q->whereIn('gender', (array) $request->gender))
            ->when($request->filled('customGender'), fn ($q) => $q->whereRaw('LOWER(gender) = LOWER(?)', [$request->customGender]))
            ->when($request->filled('cvMin'), fn ($q) => $q->whereHas('userMeta', fn ($m) => $m->where('updated_at', '>', $request->cvMin)))
            ->when($request->filled('cvMax'), fn ($q) => $q->whereHas('userMeta', fn ($m) => $m->where('updated_at', '<', $request->cvMax)))
            ->get();

        return DataTables::of($users)
            ->addColumn('id', fn (User $user) => '<input type="checkbox" class="id-candidate" name="id-' . $user->id . '" value="' . $user->id . '">')
            ->addColumn('name', fn (User $user) => '<a href="' . e(route('user.file', $user->id)) . '" target="_blank">' . e($user->name . ' ' . $user->surname) . '</a>')
            ->addColumn('age', fn (User $user) => Carbon::parse($user->birthday)->age)
            ->addColumn('education_level', function (User $user) {
                $levels = $user->userEducation
                    ->map(fn ($education) => '<p style="display: block; width: 100%; padding: 0; margin: 0">' . e($education->studies_level) . '</p>')
                    ->implode('');

                return $levels !== '' ? $levels : 'N/A';
            })
            ->addColumn('nationality', fn (User $user) => $user->nacionality ?? 'N/A')
            ->addColumn('region', fn (User $user) => $user->userMeta->state ?? 'N/A')
            ->addColumn('phone', fn (User $user) => $user->userMeta->phone ?? 'N/A')
            ->addColumn('CV', function (User $user) {
                if (! $user->userMeta) {
                    return '<p>Sin Meta</p>';
                }

                if (is_null($user->userMeta->path)) {
                    return '<p>Sin CV</p>';
                }

                return '<a target="_blank" href="' . e(asset('storage/resume/' . $user->userMeta->path)) . '"><i style="font-size: 20px;" class="far fa-file-alt"></i></a>';
            })
            ->rawColumns(['id', 'name', 'CV', 'education_level'])
            ->make(true);
    }

    /*
    |--------------------------------------------------------------------------
    | Listados públicos y postulación
    |--------------------------------------------------------------------------
    */

    public function list(): View
    {
        $userId = session('id');

        $offers = $this->activeOffers()
            ->with(['business', 'businessMeta', 'candidates', 'category'])
            ->orderByDesc('created_at')
            ->paginate(15);

        $first = $offers->first();

        // Primera oferta destacada vigente: base para saber si el usuario ya postuló.
        $featured = $this->activeOffers()
            ->where('featured', 1)
            ->with(['business', 'businessMeta', 'candidates', 'category'])
            ->orderByDesc('created_at')
            ->get()
            ->first(fn (Offers $offer) => $offer->featured_end_date >= now());

        $candidate = $featured
            ? Candidates::where('id_user', $userId)->where('id_offer', $featured->id)->first()
            : null;

        $favorite = $first && Candidates::where('id_user', $userId)
            ->where('id_offer', $first->id)
            ->where('status', 4)
            ->exists();

        if ($candidate && ($candidate->status['text'] ?? null) === 'favorite') {
            $favorite = true;
        }

        if ($first?->confidential && $first->businessMeta) {
            $first->businessMeta->business_name = 'Prestigiosa Empresa';
        }

        return view('offers.list', [
            'offers' => $offers,
            'featured' => null,
            'favorite' => $favorite,
            'postuled' => $candidate !== null,
        ]);
    }

    public function list_featured(): View
    {
        $offers = $this->activeOffers()
            ->where('featured', 1)
            ->with(['business', 'businessMeta', 'candidates'])
            ->orderByDesc('created_at')
            ->paginate(15);

        $first = $offers->first();

        return view('offers.list', [
            'offers' => $offers,
            'featured' => true,
            'favorite' => $first && Candidates::where('id_user', session('id'))
                ->where('id_offer', $first->id)
                ->where('status', 4)
                ->exists(),
            'postuled' => false,
        ]);
    }

    public function show(Request $request, string $slug, ?string $search = null): View
    {
        $userId = session('id');
        $featured = $request->featured;

        $offers = Offers::whereDate('expirated_at', '>=', now())
            ->where('published', 1)
            ->when($search !== null, fn ($query) => $query->where('title', 'LIKE', "%{$search}%"))
            ->when($featured, fn ($query) => $query->where('featured', 1))
            ->with(['businessMeta', 'business', 'Benefits', 'candidates', 'category'])
            ->latest()
            ->paginate(15);

        $offer = Offers::whereSlug($slug)->with('candidates')->first();

        if ($offer) {
            if ($offer->id_business != $userId) {
                $offer->increment('visit');
            }

            if ($offer->confidential && $offer->businessMeta) {
                $offer->businessMeta->business_name = 'Prestigiosa Empresa';
            }
        }

        $candidate = $offer
            ? Candidates::where('id_user', $userId)->where('id_offer', $offer->id)->first()
            : null;

        $favorite = $candidate && (
            $candidate->getRawOriginal('status') == 4
            || ($candidate->status['text'] ?? null) === 'favorite'
        );

        return view('offers.postulate', [
            'search' => $search,
            'hasCV' => (bool) UserMeta::where('id_user', $userId)->where('filename', '!=', '')->exists(),
            'academics' => UserEducation::where('id_user', $userId)->count(),
            'offer' => $offer,
            'slug' => $slug,
            'offers' => $offers,
            'postuled' => $candidate !== null,
            'featured' => $featured,
            'favorite' => (bool) $favorite,
        ]);
    }

    public function postulate(Offers $offer): RedirectResponse
    {
        $userId = session('id');

        if (! $userId) {
            return back()->with('message', ['danger', 'Debes iniciar sesión para postular']);
        }

        Candidates::updateOrCreate(
            ['id_user' => $userId, 'id_offer' => $offer->id],
            ['status' => 0] // 0 = postulado, no favorito
        );

        return back()->with('message', ['success', 'Has postulado a esta oferta de trabajo']);
    }

    public function favorite(Request $request): JsonResponse
    {
        $userId = session('id');

        if (is_null($userId)) {
            return response()->json(['error' => 'No estás autorizado para realizar esta acción']);
        }

        if (! $request->ajax()) {
            return response()->json(['code' => 400, 'message' => 'Bad Request'], 400);
        }

        $offer = Offers::whereSlug($request->id_offer)->firstOrFail();

        $isFavorite = Candidates::where('id_user', $userId)
            ->where('id_offer', $offer->id)
            ->where('status', 4)
            ->exists();

        if ($isFavorite) {
            Candidates::where('id_user', $userId)->where('id_offer', $offer->id)->delete();
        } else {
            Candidates::firstOrCreate(
                ['id_offer' => $offer->id, 'id_user' => $userId],
                ['status' => 4] // 4 = favorito
            );
        }

        return response()->json([
            'code' => 200,
            'message' => 'OK - ' . $offer->id . ' - ' . $userId . ' - ',
            'isFavorite' => $isFavorite ? 0 : 4,
        ]);
    }

    public function ajax(Offers $offer): JsonResponse
    {
        return response()->json($offer->load(['businessMeta', 'Benefits']));
    }

    public function apiOfertasDestacadas(): JsonResponse
    {
        $ofertas = Offers::where('published', 1)
            ->where('expirated_at', '>', now())
            ->with(['business', 'businessMeta'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get()
            ->map(function (Offers $offer) {
                $visible = ! $offer->confidential && $offer->businessMeta;

                return [
                    'id' => $offer->id,
                    'title' => $offer->title,
                    'slug' => $offer->slug,
                    'empresa' => $visible ? ($offer->businessMeta->business_name ?? 'Confidencial') : 'Confidencial',
                    'logo' => $visible ? ($offer->businessMeta->logo ?? null) : null,
                    'description' => $offer->description,
                    'area' => $offer->area,
                    'city' => $offer->city,
                    'comune' => $offer->comune,
                    'salary' => $offer->salary,
                    'position' => $offer->position,
                    'experience' => $offer->experience,
                    'vacancy' => $offer->vacancy,
                    'featured' => (bool) $offer->featured,
                    'created_at' => $offer->created_at,
                    'updated_at' => $offer->updated_at,
                    'expirated_at' => $offer->expirated_at,
                    'url' => url('/offer/show/' . $offer->slug),
                ];
            });

        return response()->json([
            'success' => true,
            'total' => $ofertas->count(),
            'data' => $ofertas,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /** Solo empresas o administradores operan sobre ofertas; las ids de candidatos y empresas colisionan. */
    private function authorizeBusinessSession(): void
    {
        abort_unless(in_array(session('role'), ['business', 'administrador'], true), 403, 'No autorizado');
    }

    /** Aborta con 403 si la oferta no pertenece a la empresa en sesión (el administrador puede operar sobre cualquiera). */
    private function authorizeOwner(Offers $offer): void
    {
        $this->authorizeBusinessSession();

        if (session('role') === 'administrador') {
            return;
        }

        abort_unless($offer->id_business == session('id'), 403, 'No autorizado');
    }

    private function activeOffers()
    {
        return Offers::whereDate('expirated_at', '>', now())->where('published', 1);
    }

    private function countFeatured(int|string|null $businessId): int
    {
        return $this->activeOffers()->where('featured', 1)->where('id_business', $businessId)->count();
    }

    private function addBenefits(Offers $offer, array $benefits): void
    {
        $rows = collect($benefits)->filter()->map(fn ($benefit) => ['benefit' => $benefit])->all();

        if ($rows) {
            $offer->Benefits()->createMany($rows);
        }
    }

    /** El slug debe ser único: si ya existe, se agrega un sufijo incremental. */
    private function uniqueSlug(string $title): string
    {
        $nextId = (Offers::withTrashed()->max('id') ?? 0) + 1;
        $base = Str::slug($title . '-' . $nextId);
        $slug = $base;

        for ($n = 2; Offers::withTrashed()->where('slug', $slug)->exists(); $n++) {
            $slug = $base . '-' . $n;
        }

        return $slug;
    }

    /** Filtra por la columna `birthday` (texto d-m-Y) entre dos fechas. */
    private function whereBirthdayBetween($query, Carbon $from, Carbon $to, bool $or = false): void
    {
        $method = $or ? 'orWhereRaw' : 'whereRaw';

        $query->{$method}(
            "STR_TO_DATE(birthday, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')",
            [$from->format('d-m-Y'), $to->format('d-m-Y')]
        );
    }
}
