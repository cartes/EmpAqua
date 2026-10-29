<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
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
            'title' => 'required',
            'position' => 'required',
            'description' => 'required|min:15|max:255',
            'area' => 'required',
            'salary' => 'integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'salary.integer' => "Renta ofrecida no puede contener puntos ni comas",
            'salary.numeric' => 'Renta ofrecida debe ser un valor numérico',
            'salary.min' => 'Renta ofrecida debe tener un valor de al menos 1',
            'description' => 'Error en la descripcion, debe tener máximo 3000 caracteres'
        ];
    }
}
