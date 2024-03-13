<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PasswordRequest extends FormRequest
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
        if (Route::is('forget.password.post'))
        {
            $rules = [
                 'email' => 'required|email|exists:users,email',
            ];
        } else {
            $rules = [
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|same:password',
            ];
        }
        return $rules;
    }
}
