<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CarProductRequest extends FormRequest
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
                    'description'   => 'required',
                    'address'       => 'required',
                    'year'          => 'required',
                    'color'         => 'required',
                    'rent'          => 'required',
                    'price'         => 'required',
                    'manual'        => 'required',
                    'distance'      => 'required',
                    'motor'         => 'required',
                    'sound'         => 'required',
                    'seat'          => 'required',
                    'phone'         => 'required',
                    'car_category_id'   => 'required',
                    'car_type_id'   => 'required',
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
                    'description'   => 'required',
                    'address'       => 'required',
                    'year'          => 'required',
                    'color'         => 'required',
                    'rent'          => 'required',
                    'price'         => 'required',
                    'manual'        => 'required',
                    'distance'      => 'required',
                    'motor'         => 'required',
                    'sound'         => 'required',
                    'seat'          => 'required',
                    'phone'         => 'required',
                    'car_type_id'   => 'required',
                    // 'country_id'    => 'required',
                    // 'state_id'      => 'required',
                    // 'city_id'       => 'required',
                    // 'status'        => 'required',
                    'images'        => 'nullable',
                    'images.*'      => 'mimes:png,jpg,jpeg,gif|max:5048'
                ];
            }

            default: break;
        }

    }
}
