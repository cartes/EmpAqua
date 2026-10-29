<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferencesRequest extends FormRequest
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
            'referencer_firstname' => 'required|min:2',
            'referencer_surname' => 'required|min:2',
            'referencer_email' => 'required|email',
            'referencer_phone' => 'required',
            'referencer_business' => 'required',
            'referencer_relation' => 'required',
            'referencer_type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'referencer_firstname.required' => "El Nombre es obligatorio",
            'referencer_firstname.min' => "El Nombre necesita al menos 2 caracteres",
            'referencer_surname.min' => "El Apellido necesita al menos 2 caracteres",
            'referencer_surname.required' => "El Apellido es obligatorio",
            'referencer_email.required' => "El email es obligatorio",
            'referencer_phone.required' => "El teléfono es obligatorio",
            'referencer_business.required' => "El nombre de la empresa es obligatorio",
            'referencer_relation.required' => "El campo de relación es obligatorio",
            'referencer_type.required' => "El tipo de empresa es obligatorio",
        ];
    }
}