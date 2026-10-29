<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'surname' => 'required|min:2',
            'email' => 'required|email|unique:aquabe_users',
            'passwordUser' => 'required|min:4',
            'phone' => 'required',
            'rut_candidate' => 'required|unique:aquabe_users,rut_user|cl_rut',
        ];
    }

    public function messages()
    {
        return [
            'rut_candidate.cl_rut' => "El Rut no es válido, digito verificador no corresponde",
            'rut_candidate.required' => "El campo Rut es obligatorio",
            "firstName.required" => "El campo Nombres es obligatorio",
            "lastName.required" => "El campo Apellidos es obligatorio",
            "email.required" => "El campo Email es obligatorio",
            "passwordUser.required" => "El campo Clave es obligatorio",
        ];
    }
}
