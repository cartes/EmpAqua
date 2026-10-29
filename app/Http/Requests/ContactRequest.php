<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'phone' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => "El campo Teléfono Celular es obligatorio",
            'email.required' => "El campo Email es obligatorio",
            'email.email' => "El campo Email debe se una dirección de email válida",
            'country.required' => "El campo País es obligatorio",
            'state.required' => "El campo Provincia es obligatorio",
            'city.required' => "El campo Ciudad es obligatorio",
            'address.required' => "El campo Dirección es obligatorio",
        ];
    }
}
