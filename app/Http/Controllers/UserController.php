<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\Candidates;
use App\Models\Message;
use App\Models\Offers;
use App\Models\Search;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            return back()->with('message', ['danger', 'Usuario no existe']);
        }

        if (! Hash::check($credentials['password'], $user->password)) {
            return redirect()->route('home')->with('message', ['danger', 'Combinación email y clave no corresponden']);
        }

        $request->session()->regenerate();
        $this->startSession($user);

        return back();
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function store(UserRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            ...$request->safe()->only(['name', 'surname', 'email']),
            'rut_user' => $request->validated('rut_candidate'),
            'password' => Hash::make($request->validated('passwordUser')),
        ]);

        $this->startSession($user);

        return redirect()->route('profile')->with('message', ['success', 'Registro exitoso']);
    }

    public function alerts(): View
    {
        $id = session('id');

        $terms = Search::where('user_id', $id)->pluck('search_term');

        $alerts = Offers::query()
            ->when(
                $terms->isNotEmpty(),
                fn ($query) => $query->where(function ($q) use ($terms) {
                    foreach ($terms as $term) {
                        $q->orWhere('title', 'like', "%{$term}%");
                    }
                })->with(['business', 'businessMeta']),
                fn ($query) => $query->where('title', 'LIKE', '%trabajo%')
            )
            ->whereDate('expirated_at', '>=', now())
            ->get();

        $postulated = Candidates::where('id_user', $id)
            ->select([
                'aquabe_offers_candidates.id',
                'aquabe_offers_candidates.status',
                'aquabe_offers.title',
                'aquabe_offers.slug as slug',
                'aquabe_business_meta.fantasy_name as fantasy_name',
                'aquabe_business_meta.comune as comune',
                'aquabe_offers.created_at',
            ])
            ->leftJoin('aquabe_offers', 'aquabe_offers_candidates.id_offer', '=', 'aquabe_offers.id')
            ->leftJoin('aquabe_business_meta', 'aquabe_offers.id_business', '=', 'aquabe_business_meta.id_business')
            ->whereDate('aquabe_offers.expirated_at', '>=', now())
            ->get();

        $user = User::with(['userMeta', 'userExperience', 'userSkills', 'userEducation', 'userReferences'])->find($id);

        return view('user.alerts', compact('alerts', 'user', 'postulated'));
    }

    public function showoffers(): View
    {
        return view('user.offers', $this->postulationsData('!='));
    }

    public function favorites(): View
    {
        return view('user.favorites', $this->postulationsData('='));
    }

    public function file(User $user, ?int $offer = null): View
    {
        if ($offer !== null) {
            Candidates::where('id_user', $user->id)
                ->where('id_offer', $offer)
                ->update(['status' => Candidates::REVIEWED]);
        }

        $user->load('userMeta', 'userExperience', 'userLanguage', 'userSkills', 'userEducation');

        return view('user.file', compact('user', 'offer'));
    }

    public function resume(User $user, ?int $offer = null): StreamedResponse
    {
        $isBusiness = in_array(session('role'), ['business', 'administrador'], true);
        abort_unless($isBusiness || (session('role') === 'user' && session('id') == $user->id), 403);

        if ($offer !== null) {
            $job = Offers::findOrFail($offer);
            abort_unless($isBusiness && (session('role') === 'administrador' || $job->id_business == session('id')), 403);
            abort_unless(Candidates::where('id_offer', $offer)->where('id_user', $user->id)->exists(), 404);
        }

        $storedPath = trim($user->userMeta?->path ?? '');
        abort_if($storedPath === '', 404, 'El postulante no tiene un CV adjunto.');

        // Admite tanto nombres de archivo antiguos como rutas relativas del disco.
        $path = str_starts_with($storedPath, 'resume/') ? $storedPath : 'resume/' . $storedPath;
        abort_if(str_contains($path, '..') || str_contains($path, '\\'), 404);
        $disk = Storage::disk('public');
        abort_unless($disk->exists($path), 404, 'El archivo del CV no está disponible.');

        return $disk->response($path, $user->userMeta->filename ?: basename($path), [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ], 'inline');
    }

    private function startSession(User $user): void
    {
        session([
            'id' => $user->id,
            'role' => 'user',
            'name' => $user->name . ' ' . $user->surname,
        ]);
    }

    /**
     * Ofertas vigentes del candidato filtradas por el estado de la postulación
     * (4 = favorito).
     */
    private function postulationsData(string $operator): array
    {
        $id = session('id');
        $user = User::findOrFail($id);

        $candidates = $user->offers()
            ->wherePivot('status', $operator, 4)
            ->where('expirated_at', '>=', now())
            ->get();

        return [
            'user' => $user,
            'candidates' => $candidates,
            'messages' => Message::where('user_id', $id)->get(),
        ];
    }
}
