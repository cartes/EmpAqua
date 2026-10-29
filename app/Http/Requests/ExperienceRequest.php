<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ExperienceRequest extends FormRequest
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
        $year = Carbon::now()->year;
        return [
            'business_name' => 'required|min:2',
            'business_position' => 'required|min:2',
            'experience_level' => 'required',
            'year_from' => 'numeric|required|min:1950|max:' . $year,
            'year_to' => 'numeric|required_without:to_present|max:'. $year .'|after_or_equal:year_from',
            'description' => 'required|min:2|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'business_name.required' => 'El campo Nombre de la empresa es obligatorio',
            'business_name.min' => 'Debe ingreser al menos 2 carácteres',
            'business_position.required' => 'El campo Puesto es obligatorio',
            'business_position.min' => 'Debe ingreser al menos 2 carácteres',
            'business_country.required' => 'El campo País es obligatorio',
            'business_country.min' => 'Debe ingreser al menos 2 carácteres',
            'experience_level.required' => 'El campo Nivel de experiencia es obligatorio',
            'year_from.required' => 'El campo Año desde es obligatorio',
            'year_from.numeric' => 'El campo Año debe ser numérico',
            'year_to.required_without' => 'El campo Año hasta es obligatorio',
            'year_to.numeric' => 'El campo Año debe ser numérico',
            'year_to.after_or_equal' => 'El campo Año Hasta debe ser posterior o igual al campo Año Desde',
        ];
    }
}
