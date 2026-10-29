<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDataRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'comune' => 'required',
            'phone' => 'required',
            'marital_status' => 'required',
            'city' => 'required',
            'birthday' => 'required|date_format:d-m-Y',
            'gender' => 'required',
            'nacionality' => 'required',
            'pretentions' => 'required',
            'objectives' => 'required',
            'picture' => 'mimes:jpg,jpeg,png|max:2048',
            //"resume" => "required|mimes:pdf,doc,docx|max:5120",
        ];
    }

    public function messages()
    {
        return [
            'marital_status.required' => 'Debe seleccionar una opción',
            'birthday.required' => "El campo Fecha de Nacimiento es obligatorio",
            "birthday.date_format" => "El formato no corresponde (dd-mm-yyyy)",
            'gender.required' => "El campo Género es obligatorio",
            'nacionality.required' => "El campo Nacionalidad es obligatorio",
            'objectives.required' => "Los Objetivos Laborales son obligatorio",
            'picture.mimes' => "Solo formato jpeg o png",
            'picture.max' => "Archivo debe pesar menos de 2 Mbytes",
            //'resume.required' => "Subir un CV es obligatorio",
        ];
    }
}
