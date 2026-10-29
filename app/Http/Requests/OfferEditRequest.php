<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'category_id' => ['required'],
            'position' => ['required'],
            'salary_opt' => ['required', 'numeric'],
            'handicapped' => ['required', 'in:0,1'],
            'description' => ['required', 'min:10', 'max:3500'],
            'area' => ['required'],
            'experience' => ['required', 'integer'],
            'requirements' => ['required'],
            'vacancy' => ['required', 'integer'],
            'benefit' => ['nullable', 'string', 'max:255'],
            'benefits' => ['nullable', 'array'],
            'benefits.*' => ['nullable', 'string', 'max:255'],
        ];
    }
}
