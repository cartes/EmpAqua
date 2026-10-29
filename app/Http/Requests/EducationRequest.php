<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'studies' => 'required',
            'title' => 'required|min:3',
            'institution' => 'required',
            'condition' => 'required',
            'year_to_st' => 'required_unless:condition,3|integer|max:' . (date('Y') + 1),
        ];
    }

    public function messages() {
        return [
            'year_to.required_unless' => "Campo obligatorio",
            'year_to.required' => "Campo obligatorio",
        ];
    }
}
