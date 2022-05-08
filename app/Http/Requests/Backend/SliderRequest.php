<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                    'title'     => 'nullable',
                    'text'      => 'nullable',
                    'image'     => 'nullable|mimes:png,jpg,jpeg,tif,tiff,bmp,gif'
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'title'     => 'nullable',
                    'text'      => 'nullable',
                    'image'     => 'nullable|mimes:png,jpg,jpeg,tif,tiff,bmp,gif'
                ];
            }

            default: break;
        }

    }
}
