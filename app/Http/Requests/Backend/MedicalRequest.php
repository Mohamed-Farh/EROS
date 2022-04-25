<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRequest extends FormRequest
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
        switch ($this->method()){
            case 'POST':
            {
                return[
                    'name'          => 'required',
                    // 'gender'        => 'required',
                    // 'type'          => 'required',
                    // 'speciality'    => 'required',
                    'description'   => 'required',
                    'address'       => 'required',
                    'work_hours'    => 'required',
                    // 'exp_years'     => 'required',
                    'phone'         => 'required',
                    // 'country_id'    => 'required',
                    // 'state_id'      => 'required',
                    // 'city_id'       => 'required',
                    // 'status'        => 'required',
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'name'          => 'required',
                    // 'gender'        => 'required',
                    // 'type'          => 'required',
                    // 'speciality'    => 'required',
                    'description'   => 'required',
                    'address'       => 'required',
                    'work_hours'    => 'required',
                    // 'exp_years'     => 'required',
                    'phone'         => 'required',
                    // 'country_id'    => 'required',
                    // 'state_id'      => 'required',
                    // 'city_id'       => 'required',
                    // 'status'        => 'required',
                ];
            }

            default: break;
        }

    }
}
