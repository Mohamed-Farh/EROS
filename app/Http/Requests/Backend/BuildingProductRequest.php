<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class BuildingProductRequest extends FormRequest
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
                    'size'          => 'required',
                    'bedroom'       => 'required',
                    'bathroom'      => 'required',
                    'hall'          => 'required',
                    'price'         => 'required',
                    'phone'         => 'required',
                    'building_category_id'   => 'required',
                    'rent'          => 'required',
                    // 'country_id'    => 'required',
                    // 'state_id'      => 'required',
                    // 'city_id'       => 'required',
                    // 'status'        => 'required',
                    // 'images'        => 'required',
                    'images.*'      => 'mimes:png,jpg,jpeg,gif|max:5048'
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'name'          => 'required|max:255',
                    'description'   => 'required',
                    'address'       => 'required',
                    'size'          => 'required',
                    'bedroom'       => 'required',
                    'bathroom'      => 'required',
                    'hall'          => 'required',
                    'price'         => 'required',
                    'phone'         => 'required',
                    'rent'          => 'required',
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
