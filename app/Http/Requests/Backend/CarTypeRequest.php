<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CarTypeRequest extends FormRequest
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
                    'name'      => 'required|max:255|unique:car_types,name',
                    'status'    => 'required',
                    'cover'     => 'required|mimes:png,jpg,jpeg|max:5048'
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'name'      => 'required|max:255|unique:car_types,name,'.$this->route()->carType->id,
                    'status'    => 'required',
                    'cover'     => 'nullable|mimes:png,jpg,jpeg|max:5048'
                ];
            }

            default: break;
        }

    }
}
