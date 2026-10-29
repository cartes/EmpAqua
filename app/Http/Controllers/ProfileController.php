<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\EducationRequest;
use App\Http\Requests\ExperienceRequest;
use App\Http\Requests\PersonalDataRequest;
use App\Http\Requests\ReferencesRequest;
use App\Http\Requests\ResumeRequest;
use App\Models\Reference;
use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserLanguage;
use App\Models\UserMeta;
use App\Models\UserSkills;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        $id = session()->get('id');
        $fileExists = false;
        $user = User::where('id', $id)
            ->first()
            ->load('userMeta', 'userLanguage', 'userSkills', 'userReferences');

        if (!is_null($user->userMeta) && !is_null($user->userMeta->path)) {
            $fileExists = file_exists(storage_path('app/public/resume/' . $user->userMeta->path));
            // **Nota: Ya NO sets session()->flash aquí.**
        }

        $experiences = UserExperience::whereIdUser($id)->orderBy('year_to', 'DESC')->orderBy('month_to', 'DESC')->get();
        $education = UserEducation::whereIdUser($id)->orderBy('year_to')->get();

        return view('user.profile')->with([
            'user' => $user,
            'experiences' => $experiences,
            'education' => $education,
            'fileExists' => $fileExists,
        ]);
    }


    public function update(PersonalDataRequest $request)
    {
        $id = session()->get('id');

        $user = User::where('id', $id)->first();
        $hasEducation = $this->hasExistingEducation($user);

        $date = str_replace('/', '-', $request->get('birthday'));

        if ($request->hasFile('resume')) {
            $path = Helper::uploadFile('resume', 'resume');
            $file = $request->file('resume');

            UserMeta::updateOrCreate(['id_user' => $id], [
                'path' => $path,
                'filename' => $file->getClientOriginalName(),
            ]);
        }

        if ($request->hasFile('picture')) {
            $path = Helper::uploadFile('picture', 'profile');

            User::where('id', $id)
                ->update([
                    'name' => $request->get('name'),
                    'surname' => $request->get('surname'),
                    'birthday' => $date,
                    'gender' => $request->get('gender'),
                    'nacionality' => $request->get('nacionality'),
                    'marital_status' => $request->get('marital_status'),
                    'path' => basename($path),
                    'picture' => $request->file('picture')->getClientOriginalName(),
                ]);

        } else {
            User::where('id', $id)
                ->update([
                    'name' => $request->get('name'),
                    'surname' => $request->get('surname'),
                    'birthday' => $date,
                    'gender' => $request->get('gender'),
                    'nacionality' => $request->get('nacionality'),
                    'marital_status' => $request->get('marital_status'),
                ]);
        }

        UserMeta::updateOrCreate(['id_user' => $id], [
            'pretentions' => $request->pretentions,
            'objectives' => $request->objectives,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'comune' => $request->comune,
        ]);

        if ($hasEducation) {
            return back()->with('message', ['success', 'Datos actualizados']);
        } else {
            return back()->with('message', ['error', 'Debes agregar tu información académica']);
        }
    }

    public function salary(Request $request)
    {
        $id = session()->get('id');

        try {
            UserMeta::updateOrCreate(
                ['id_user' => $id],
                ['pretentions' => $request->get('pretentions')]
            );
            $success = true;

        } catch (\Exception $exc) {
            $success = $exc->getMessage();
        }

        if ($success) {
            return back()->with('message', ['success', 'Renta actualizada']);
        }

    }

    public function contact(ContactRequest $request)
    {
        $id = session()->get('id');

        try {
            User::where('id', $id)
                ->update([
                    'email' => $request->get('email')
                ]);
            UserMeta::updateOrCreate(
                ['id_user' => $id],
                [
                    'phone' => $request->get('phone'),
                    'address' => $request->get('address'),
                    'comune' => $request->get('comune'),
                    'city' => $request->get('city'),
                    'state' => $request->get('state'),
                    'country' => $request->get('country'),
                ]
            );

            $success = true;


        } catch (\Exception $exc) {
            $success = $exc->getMessage();
        }

        if ($success) {
            return back()->with('message', ['success', 'Datos de contacto actualizados']);
        }

    }

    public function getExperience($id)
    {
        try {
            // Buscar la experiencia laboral por su ID
            $experience = UserExperience::findOrFail($id);

            // Devolver los datos en formato JSON
            return response()->json($experience);
        } catch (\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }


    public function experience(ExperienceRequest $request)
    {
        $id = session()->get('id');

        $experience = new UserExperience;
        try {
            $experience->id_user = $id;
            $experience->business_name = $request->business_name;
            $experience->business_activity = $request->business_activity;
            $experience->business_position = $request->business_position;
            $experience->experience_level = $request->experience_level;
            $experience->business_country = $request->business_country;
            $experience->month_from = $request->month_from;
            $experience->year_from = $request->year_from;
            $experience->month_to = $request->month_to;
            $experience->year_to = $request->year_to;
            $experience->area = $request->area;
            $experience->sub_area = $request->sub_area;
            $experience->description = $request->description;
            $experience->dependents = $request->dependents;

            $experience->save();

            $success = true;
            return back()->with('message', ['success', 'Experiencia Laboral Actualizada']);

        } catch (\Exception $exc) {
            return back()->with('message', ['error', $exc->getMessage()]);
        }
    }

    public function updateExperience(ExperienceRequest $request)
    {
        $id = session()->get('id');

        $user = User::where('id', $id)->first();
        $hasEducation = $this->hasExistingEducation($user);

        try {
            // Obtener el id_experience desde el request
            $id = $request->input('id_experience');

            // Buscar la experiencia laboral existente por su ID
            $experience = UserExperience::findOrFail($id);

            // Actualizar los campos con los datos del formulario
            $experience->business_name = $request->business_name;
            $experience->business_activity = $request->business_activity;
            $experience->business_position = $request->business_position;
            $experience->experience_level = $request->experience_level;
            $experience->business_country = $request->business_country;
            $experience->month_from = $request->month_from;
            $experience->year_from = $request->year_from;
            $experience->month_to = $request->month_to;
            $experience->year_to = $request->year_to;
            $experience->area = $request->area;
            $experience->sub_area = $request->sub_area;
            $experience->description = $request->description;
            $experience->dependents = $request->dependents;

            // Guardar los cambios en la base de datos
            $experience->save();

            // Redirigir con un mensaje de éxito

            if ($hasEducation) {
                return back()->with('message', ['success', 'Experiencia Laboral Actualizada']);
            } else {
                return back()->with('message', ['error', 'Debes agregar tu información académica']);
            }

        } catch (\Exception $exc) {
            // En caso de error, redirigir con un mensaje de error
            return back()->with('message', ['error', $exc->getMessage()]);
        }
    }

    public function editEducation($id)
    {
        $education = UserEducation::find($id);

        if ($education) {
            return response()->json($education);
        } else {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }

    public function education(EducationRequest $request)
    {
        $id = session()->get('id');
        $education = new UserEducation;

        try {
            $education->id_user = $id;
            $education->country = $request->input('country');
            $education->studies = $request->input('studies');
            $education->condition = $request->input('condition');
            $education->title = $request->input('title');
            $education->area = $request->input('area');
            $education->month_from = $request->input('month_from');
            $education->year_from = $request->input('year_from');
            $education->month_to = $request->input('month_to');
            $education->year_to = $request->input('year_to_st');
            $education->to_present = $request->input('to_present');
            $education->institution = $request->input('institution');

            $education->save();

            $success = true;
        } catch (\Exception $exc) {
            return back()->with('message', ['error', $exc->getMessage()]);
        }

        if ($success) {
            return back()->with('message', ['success', 'Información académica guardada con éxito']);
        }

    }

    public function updateEducation(Request $request)
    {
        $request->validate([
            'id_education' => 'required|exists:aquabe_users_education,id_education',
            'studies' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'condition' => 'required|integer',
            'year_to' => 'required_unless:condition,3|integer|min:1900|max:' . date('Y'),
        ]);

        try {
            $education = UserEducation::find($request->id_education);

            $education->studies = $request->studies;
            $education->title = $request->title;
            $education->institution = $request->institution;
            $education->condition = $request->condition;
            $education->year_to = $request->year_to;

            $education->save();

            return redirect()->back()->with('message', ['success', 'Educación actualizada con éxito']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', ['error', 'Error al actualizar la educación']);
        }
    }

    public function objectives(Request $request)
    {
        $id = session()->get('id');

        $user = User::where('id', $id)->first();
        $hasEducation = $this->hasExistingEducation($user);

        try {
            UserMeta::updateOrCreate(
                ['id_user' => $id],
                ['objectives' => $request->get('objectives')]
            );
            $success = true;

        } catch (\Exception $exc) {
            $success = $exc->getMessage();
        }

        if ($success) {
            if ($hasEducation) {
                return back()->with('message', ['success', 'Objetivos laborales Actualizada']);
            } else {
                return back()->with('message', ['error', 'Debes agregar tu información académica']);
            }
        }
    }

    public function languages(Request $request)
    {
        $id = session()->get('id');

        $user = User::where('id', $id)->first();
        $hasEducation = $this->hasExistingEducation($user);
        $lang = new UserLanguage;

        try {
            $lang->id_user = $id;
            $lang->language = $request->language;
            $lang->level_written = $request->level_written;
            $lang->level_spoken = $request->level_spoken;

            $lang->save();

            $success = true;
        } catch (\Exception $exc) {
            $success = $exc->getMessage();
        }

        if ($success) {
            if ($hasEducation) {
                return back()->with('message', ['success', 'Idiomas Actualizados']);
            } else {
                return back()->with('message', ['error', 'Debes agregar tu información académica']);
            }
        }

    }

    public function skills(Request $request)
    {
        $id = session()->get('id');

        $user = User::where('id', $id)->first();
        $hasEducation = $this->hasExistingEducation($user);

        $skills = new UserSkills;

        try {
            $skills->id_user = $id;
            $skills->skill = $request->skill;
            $skills->save();

            $success = true;
        } catch (\Exception $exc) {
            $success = $exc->getMessage();
        }

        if ($success) {
            if ($hasEducation) {
                return back()->with('message', ['success', 'Habilidades Actualizada']);
            } else {
                return back()->with('message', ['error', 'Debes agregar tu información académica']);
            }
        } else {
            return back()->with('message', ['error', $success]);
        }

    }

    public function references(ReferencesRequest $request)
    {
        $id = session()->get('id');

        $user = User::where('id', $id)->first();
        $hasEducation = $this->hasExistingEducation($user);

        $request->merge(['id_user' => session()->get('id')]);

        Reference::create($request->input());

        if ($hasEducation) {
            return back()->with('message', ['success', 'Referencia agregada']);
        } else {
            return back()->with('message', ['error', 'Debes agregar tu información académica']);
        }
    }

    public function editReference($id)
    {
        $reference = Reference::findOrFail($id);
        return response()->json($reference);
    }

    public function updateReference(Request $request)
    {
        $request->validate([
            'id_references' => 'required|exists:aquabe_users_references,id_references',
            'referencer_firstname' => 'required|string|max:255',
            'referencer_surname' => 'required|string|max:255',
            'referencer_email' => 'required|email|max:255',
            'referencer_phone' => 'required|string|max:20',
            'referencer_business' => 'required|string|max:255',
            'referencer_relation' => 'required|string|max:255',
            'referencer_type' => 'required|string|max:255',
        ]);

        try {
            $reference = Reference::find($request->id_references);

            $reference->referencer_firstname = $request->referencer_firstname;
            $reference->referencer_surname = $request->referencer_surname;
            $reference->referencer_email = $request->referencer_email;
            $reference->referencer_phone = $request->referencer_phone;
            $reference->referencer_business = $request->referencer_business;
            $reference->referencer_relation = $request->referencer_relation;
            $reference->referencer_type = $request->referencer_type;

            $reference->save();

            return redirect()->back()->with('message', ['success', 'Referencia actualizada con éxito']);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', ['error', 'Error al actualizar la referencia']);
        }
    }

    public function resume(Request $request)
    {
        $id = session()->get('id');
        $userMeta = UserMeta::where('id_user', $id)->first();


        $rules = [];
        if (empty($userMeta) || empty($userMeta->path)) {
            $rules['resume'] = 'required|file|mimes:pdf,doc,docx|max:5120';
        } else {
            $rules['resume'] = 'nullable|file|mimes:pdf,doc,docx|max:5120';
        }
        $rules['extra_doc'] = 'nullable|file|mimes:pdf,doc,docx|max:5120';
        $rules['support_doc'] = 'nullable|file|mimes:pdf,doc,docx|max:5120';

        $request->validate($rules);

        $updateData = [];

        if ($request->hasFile('resume')) {
            $filePath = Helper::uploadFile('resume', 'resume');
            $fileName = $request->file('resume')->getClientOriginalName();
            $updateData['path'] = $filePath;
            $updateData['filename'] = $fileName;
        }
        if ($request->hasFile('extra_doc')) {
            $extraPath = Helper::uploadFile('extra_doc', 'resume');
            $extraName = $request->file('extra_doc')->getClientOriginalName();
            $updateData['extra_path'] = $extraPath;
            $updateData['extra_filename'] = $extraName;
        }
        if ($request->hasFile('support_doc')) {
            $supportPath = Helper::uploadFile('support_doc', 'resume');
            $supportName = $request->file('support_doc')->getClientOriginalName();
            $updateData['support_doc_path'] = $supportPath;
            $updateData['support_doc_name'] = $supportName;
        }

        if ($userMeta) {
            $userMeta->update($updateData);
            $userMeta->refresh();
        } else {
            $userMeta = UserMeta::create(array_merge($updateData, ['id_user' => $id]));
        }

        return back()->with('message', ['success', 'Archivo(s) subido(s) correctamente']);
    }


    // la proxima vez que me veas eliminamé, pq ya no me usan
    // public function resume(ResumeRequest $request)
    // {
    //     $id = session()->get('id');
    //     
    //     $user = User::where('id', $id)->first();
    //     $hasEducation = $this->hasExistingEducation($user);
    //     $hasCV = $this->hasCV($user);

    //     $file = Helper::uploadFile('resume', 'resume');
//         $reference = $request->files;
// 
//         $userMeta = UserMeta::where('id_user', '=', $id)->update([
//             'path' => $file->hashName(),
//             'filename' => $file->getClientOriginalName(),
//         ]);

    //dd($userMeta);

    //         if ($hasEducation && $hasCV) {
//             return back()->with('message', ['success', 'Curriculum Subido']);
//         } elseif(!$hasEducation) {
//             return back()->with('message', ['error', 'Debes subir Información Académica']);
//         } else {
//             return back()->with('message', ['error', 'Debes subir tu curriculum']);
//         }
//     }

    public function view()
    {
        $id = session()->get('id');
        $user = User::where('id', $id)
            ->first()
            ->load('userMeta', 'userLanguage', 'userSkills', 'userEducation', 'userReferences');

        $experiences = UserExperience::whereIdUser($id)->orderBy('year_to', 'DESC')->orderBy('month_to', 'DESC')->get();

        return view("user.view")->with([
            "user" => $user,
            "experiences" => $experiences,
        ]);

    }

    /**
     * Api
     */

    public function eraseExp(Request $request)
    {
        $id = session()->get('id');
        $id_experience = $request->get('id');

        $experience = UserExperience::where([
            'id_experience' => $id_experience,
            'id_user' => $id
        ])->delete();

        return response()->json($experience);
    }

    public function eraseEducation(Request $request)
    {
        $id = session()->get('id');
        $id_education = $request->get('id');

        $education = UserEducation::where([
            'id_education' => $id_education,
            'id_user' => $id
        ])->delete();
    }


    public function eraseReference(Request $request)
    {
        $id = session()->get('id');
        $id_references = $request->get('id');

        $education = Reference::where([
            'id_references' => $id_references,
            'id_user' => $id
        ])->delete();
    }

    public function eraseSkill(Request $request)
    {
        $id = session()->get('id');
        $id_skills = $request->get('id');

        $education = UserSkills::where([
            'id_skills' => $id_skills,
            'id_user' => $id
        ])->delete();
    }

    public function eraseFile(Request $request)
    {
        $id = $request->input('id');
        $fileType = $request->input('file_type'); // resume | extra | support_doc
        $userMeta = UserMeta::find($id);

        if ($userMeta) {
            // Determina el campo correcto según el tipo
            switch ($fileType) {
                case 'resume':
                    $pathField = 'path';
                    $nameField = 'filename';
                    break;
                case 'extra':
                    $pathField = 'extra_path';
                    $nameField = 'extra_filename';
                    break;
                case 'support_doc':
                    $pathField = 'support_doc_path';
                    $nameField = 'support_doc_name';
                    break;
                default:
                    return response()->json(['error' => 'Tipo de archivo inválido'], 400);
            }

            // Borra el archivo físico
            if (!empty($userMeta->$pathField)) {
                \Storage::disk('public')->delete($userMeta->$pathField);
            }
            // Borra datos en base
            $userMeta->$pathField = null;
            $userMeta->$nameField = null;
            $userMeta->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Registro no encontrado'], 404);
    }



    protected function hasCV(User $user)
    {
        return $user->userMeta && !is_null($user->userMeta->filename);
    }

    protected function hasExistingEducation(User $user)
    {
        return $user->userEducation()->exists();
    }

}
