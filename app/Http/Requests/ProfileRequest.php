<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $rules =
            [
                'name' => 'required',
                'email' => ['required', 'email', Rule::unique('users')->ignore($this->id)],
                'confirm_password' => 'same:password',
                'image' => 'mimes:jpeg,png,jpg',
            ];

        return $rules;
    }
}
