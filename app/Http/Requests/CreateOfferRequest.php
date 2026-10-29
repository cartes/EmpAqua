<?php

namespace App\Http\Requests;

use App\Rules\BlacklistWords;
use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', new BlacklistWords],
            'category_id' => ['required'],
            'position' => ['required'],
            'salary_opt' => ['required'],
            'comune' => ['required'],
            'handicapped' => ['required'],
            'description' => ['required', new BlacklistWords],
            'area' => ['required'],
            'experience' => ['required'],
            'requirements' => ['required', new BlacklistWords],
            'vacancy' => ['required'],
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'salary_opt.required' => 'Debe ingresar una opcion de renta',
            'salary.integer' => 'Renta ofrecida no puede contener puntos ni comas',
            'salary.numeric' => 'Renta ofrecida debe ser un valor numérico',
            'salary.min' => 'Renta ofrecida debe tener un valor de al menos 1',
            'comune.required' => 'La comuna es obligatoria',
            'category_id.required' => 'Debe seleccionar una categoría',
            'handicapped.required' => 'Campo obligatorio',
            'position.required' => 'La Jornada es un campo obligatorio',
            'description.required' => 'La descripción es un campo obligatorio',
            'requirements.required' => 'Los requisitos son obligatorios',
            'vacancy.required' => 'Las vacantes son un campo obligatorio',
        ];
    }
}
