<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\ExperienceRequest;
use App\Http\Requests\PersonalDataRequest;
use App\Http\Requests\ReferencesRequest;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Perfil del candidato. Todos los registros se acceden a través del usuario en sesión,
 * de modo que nadie puede leer ni modificar datos de otro candidato.
 */
class ProfileController extends Controller
{
    private const EXPERIENCE_FIELDS = [
        'business_name', 'business_activity', 'business_position', 'experience_level', 'business_country',
        'month_from', 'year_from', 'month_to', 'year_to', 'area', 'sub_area', 'description', 'dependents',
    ];

    private const REFERENCE_FIELDS = [
        'referencer_firstname', 'referencer_surname', 'referencer_email', 'referencer_phone',
        'referencer_business', 'referencer_relation', 'referencer_type',
    ];

    public function index(): View
    {
        $user = $this->user()->load('userMeta', 'userLanguage', 'userSkills', 'userReferences');

        $path = $user->userMeta?->path;
        $fileExists = ! is_null($path) && file_exists(storage_path('app/public/resume/' . $path));

        return view('user.profile', [
            'user' => $user,
            'experiences' => $this->experiences($user),
            'education' => $user->userEducation()->reorder('year_to')->get(),
            'fileExists' => $fileExists,
        ]);
    }

    public function view(): View
    {
        $user = $this->user()->load('userMeta', 'userLanguage', 'userSkills', 'userEducation', 'userReferences');

        return view('user.view', [
            'user' => $user,
            'experiences' => $this->experiences($user),
        ]);
    }

    public function update(PersonalDataRequest $request): RedirectResponse
    {
        $user = $this->user();

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'birthday' => str_replace('/', '-', (string) $request->birthday),
            'gender' => $request->gender,
            'nacionality' => $request->nacionality,
            'marital_status' => $request->marital_status,
        ];

        if ($request->hasFile('picture')) {
            $data['path'] = Helper::uploadFile('picture', 'profile');
            $data['picture'] = $request->file('picture')->getClientOriginalName();
        }

        $user->forceFill($data)->save();

        $meta = [
            'pretentions' => $request->pretentions,
            'objectives' => $request->objectives,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'comune' => $request->comune,
        ];

        if ($request->hasFile('resume')) {
            $meta['path'] = Helper::uploadFile('resume', 'resume');
            $meta['filename'] = $request->file('resume')->getClientOriginalName();
        }

        $this->saveMeta($user, $meta);

        return $this->respond($user, 'Datos actualizados');
    }

    public function salary(Request $request): RedirectResponse
    {
        $this->saveMeta($this->user(), ['pretentions' => $request->pretentions]);

        return back()->with('message', ['success', 'Renta actualizada']);
    }

    public function contact(ContactRequest $request): RedirectResponse
    {
        $user = $this->user();

        $user->update(['email' => $request->email]);
        $this->saveMeta($user, $request->only(['phone', 'address', 'comune', 'city', 'state', 'country']));

        return back()->with('message', ['success', 'Datos de contacto actualizados']);
    }

    public function objectives(Request $request): RedirectResponse
    {
        $user = $this->user();
        $this->saveMeta($user, ['objectives' => $request->objectives]);

        return $this->respond($user, 'Objetivos laborales Actualizada');
    }

    /*
    |--------------------------------------------------------------------------
    | Experiencia laboral
    |--------------------------------------------------------------------------
    */

    public function getExperience(int $id): JsonResponse
    {
        return response()->json($this->user()->userExperience()->findOrFail($id));
    }

    public function experience(ExperienceRequest $request): RedirectResponse
    {
        $this->user()->userExperience()->create($request->only(self::EXPERIENCE_FIELDS));

        return back()->with('message', ['success', 'Experiencia Laboral Actualizada']);
    }

    public function updateExperience(ExperienceRequest $request): RedirectResponse
    {
        $user = $this->user();

        $user->userExperience()
            ->findOrFail($request->input('id_experience'))
            ->update($request->only(self::EXPERIENCE_FIELDS));

        return $this->respond($user, 'Experiencia Laboral Actualizada');
    }

    public function eraseExp(Request $request): JsonResponse
    {
        return response()->json($this->user()->userExperience()->whereKey($request->id)->delete());
    }

    /*
    |--------------------------------------------------------------------------
    | Educación
    |--------------------------------------------------------------------------
    */

    public function editEducation(int $id): JsonResponse
    {
        $education = $this->user()->userEducation()->find($id);

        return $education
            ? response()->json($education)
            : response()->json(['error' => 'Registro no encontrado'], 404);
    }

    public function education(EducationRequest $request): RedirectResponse
    {
        $this->user()->userEducation()->create([
            ...$request->only(['country', 'studies', 'condition', 'title', 'area', 'month_from', 'year_from', 'month_to', 'to_present', 'institution']),
            'year_to' => $request->input('year_to_st') ?? '',
        ]);

        return back()->with('message', ['success', 'Información académica guardada con éxito']);
    }

    public function updateEducation(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_education' => ['required', 'exists:aquabe_users_education,id_education'],
            'studies' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'integer'],
            'year_to' => ['required_unless:condition,3', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        $this->user()->userEducation()
            ->findOrFail($data['id_education'])
            ->update(collect($data)->except('id_education')->all());

        return back()->with('message', ['success', 'Educación actualizada con éxito']);
    }

    public function eraseEducation(Request $request): JsonResponse
    {
        return response()->json($this->user()->userEducation()->whereKey($request->id)->delete());
    }

    /*
    |--------------------------------------------------------------------------
    | Idiomas, habilidades y referencias
    |--------------------------------------------------------------------------
    */

    public function languages(Request $request): RedirectResponse
    {
        $user = $this->user();
        $user->userLanguage()->create($request->only(['language', 'level_written', 'level_spoken']));

        return $this->respond($user, 'Idiomas Actualizados');
    }

    public function skills(Request $request): RedirectResponse
    {
        $user = $this->user();
        $user->userSkills()->create($request->only(['skill']));

        return $this->respond($user, 'Habilidades Actualizada');
    }

    public function eraseSkill(Request $request): JsonResponse
    {
        return response()->json($this->user()->userSkills()->whereKey($request->id)->delete());
    }

    public function references(ReferencesRequest $request): RedirectResponse
    {
        $user = $this->user();
        $user->userReferences()->create($request->only(self::REFERENCE_FIELDS));

        return $this->respond($user, 'Referencia agregada');
    }

    public function editReference(int $id): JsonResponse
    {
        return response()->json($this->user()->userReferences()->findOrFail($id));
    }

    public function updateReference(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_references' => ['required', 'exists:aquabe_users_references,id_references'],
            'referencer_firstname' => ['required', 'string', 'max:255'],
            'referencer_surname' => ['required', 'string', 'max:255'],
            'referencer_email' => ['required', 'email', 'max:255'],
            'referencer_phone' => ['required', 'string', 'max:20'],
            'referencer_business' => ['required', 'string', 'max:255'],
            'referencer_relation' => ['required', 'string', 'max:255'],
            'referencer_type' => ['required', 'string', 'max:255'],
        ]);

        $this->user()->userReferences()
            ->findOrFail($data['id_references'])
            ->update(collect($data)->except('id_references')->all());

        return back()->with('message', ['success', 'Referencia actualizada con éxito']);
    }

    public function eraseReference(Request $request): JsonResponse
    {
        return response()->json($this->user()->userReferences()->whereKey($request->id)->delete());
    }

    /*
    |--------------------------------------------------------------------------
    | Archivos
    |--------------------------------------------------------------------------
    */

    public function resume(Request $request): RedirectResponse
    {
        $user = $this->user();
        $meta = $user->userMeta;
        $document = ['file', 'mimes:pdf,doc,docx', 'max:5120'];

        $request->validate([
            'resume' => [empty($meta?->path) ? 'required' : 'nullable', ...$document],
            'extra_doc' => ['nullable', ...$document],
            'support_doc' => ['nullable', ...$document],
        ]);

        $data = [];

        foreach ([
            'resume' => ['path', 'filename'],
            'extra_doc' => ['extra_path', 'extra_filename'],
            'support_doc' => ['support_doc_path', 'support_doc_name'],
        ] as $input => [$pathColumn, $nameColumn]) {
            if ($request->hasFile($input)) {
                $data[$pathColumn] = Helper::uploadFile($input, 'resume');
                $data[$nameColumn] = $request->file($input)->getClientOriginalName();
            }
        }

        $this->saveMeta($user, $data);

        return back()->with('message', ['success', 'Archivo(s) subido(s) correctamente']);
    }

    public function eraseFile(Request $request): JsonResponse
    {
        $columns = [
            'resume' => ['path', 'filename'],
            'extra' => ['extra_path', 'extra_filename'],
            'support_doc' => ['support_doc_path', 'support_doc_name'],
        ][$request->input('file_type')] ?? null;

        if (! $columns) {
            return response()->json(['error' => 'Tipo de archivo inválido'], 400);
        }

        $meta = $this->user()->userMeta;

        if (! $meta || $meta->getKey() != $request->input('id')) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        [$pathColumn, $nameColumn] = $columns;

        if (! empty($meta->{$pathColumn})) {
            Storage::disk('public')->delete($meta->{$pathColumn});
        }

        $meta->forceFill([$pathColumn => null, $nameColumn => null])->save();

        return response()->json(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function user(): User
    {
        return User::findOrFail(session('id'));
    }

    private function experiences(User $user)
    {
        return $user->userExperience()->orderByDesc('year_to')->orderByDesc('month_to')->get();
    }

    private function saveMeta(User $user, array $data): void
    {
        UserMeta::updateOrCreate(['id_user' => $user->id], $data);
    }

    /** Mensaje de éxito, o aviso si el candidato aún no registra información académica. */
    private function respond(User $user, string $success): RedirectResponse
    {
        return back()->with(
            'message',
            $user->userEducation()->exists()
                ? ['success', $success]
                : ['error', 'Debes agregar tu información académica']
        );
    }
}
