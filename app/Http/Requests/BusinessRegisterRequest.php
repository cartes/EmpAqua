<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRegisterRequest extends FormRequest
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
            'firstname' => 'required|min:2',
            'surname' => 'required|min:2',
            'email_business' => 'required|email|unique:aquabe_business,email_user',
            'phone_business' => 'required',
            'rut_user' => 'required|unique:aquabe_business,rut_user|cl_rut',
            'position' => 'required',
            'passbusiness' => 'required|confirmed|min:4',
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => "El campo Nombre es obligatorio",
            'firstname.min' => "El campo Nombre debe contener al menos 2 caracteres",
            'surname.required' => "El campo Apellido es obligatorio",
            'rut_user.cl_rut' => "Debe ingresar un rut válido",
            'rut_user.unique' => "El Rut ya está registrado",
            'surname.min' => "El campo Apellido debe contener al menos 2 caracteres",
            'email_business.required' => "El campo Email es obligatorio",
            'email_business.unique' => "Este Email ya está registrado",
            'passbusiness.required' => "Necesitas rellenar la contraseña"
        ];
    }
}
