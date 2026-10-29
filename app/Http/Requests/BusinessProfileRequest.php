<?php

namespace App\Http\Requests;

use App\Business;
use App\BusinessMeta;
use Illuminate\Foundation\Http\FormRequest;

class BusinessProfileRequest extends FormRequest
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
        $id_business = session()->get('id');
        $id = BusinessMeta::where('id_business', $id_business)->select('id')->first();
        $business = !empty($id) ? $id->id : '';
        return [
            'rut_business' => 'required|cl_rut|unique:aquabe_business_meta,rut_business,' . $business,
            'business_name' => 'required',
            'fantasy_name' => 'required',
            'surname' => 'required',
            'phone_user' => 'required',
            'activity' => 'required',
            'address' => 'required',
            'comune' => 'required',
            'city' => 'required',
            'state' => 'required',
//           'email' => 'email|unique:aquabe_business_meta,email',
//           'phone' => 'required',
            'employees' => 'required'
        ];
    }

    public function messages() {
        return [
            'rut_business.required' => "El Rut es obligatorio",
            'rut_business.cl_rut' => 'El rut no es válido',
            'business_name.required' => 'La razón social es obligatoria',
            'fantasy_name.required' => 'El nombre de fantasía es obligatorio',
            'activity.required' => 'El giro es obligatorio',
            'address.required' => 'La dirección es obligatoria',
            'commune.required' => 'La comuna es obligatoria',
            'city.required' => 'La ciudad es obligatoria',
            'state.required' => 'La región es obligatoria',
            'phone.required' => 'El teléfono es obligatorio',
            'phone_user.required' => 'El teléfono del adinistrador es obligatorio',
            'surname.required' => 'El apellido es obligatorio',
            'name.required' => 'El nombre es obligatorio',
            'employees.required' => 'La cantidad de empleados es obligatoria',
        ];
    }
}
