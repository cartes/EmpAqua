<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeRequest extends FormRequest
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
            "resume" => "required|mimes:pdf,doc,docx|max:5120"
        ];
    }
    
        public function messages()
    {
        return [
            'resume.required' => "Subir un CV es obligatorio",
        ];
    }

}
