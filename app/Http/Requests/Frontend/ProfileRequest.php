<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_id'       => ['nullable', 'exists:users,id'],
            'day'           => ['required', 'date', 'after_or_equal:now'],
        ];
    }

    public function attributes()
    {
        return [
            // 'user_image' => 'Profile image',
        ];
    }

}
