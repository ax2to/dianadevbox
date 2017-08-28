<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'lastName' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required',
        ];

        if ($this->method() == 'PUT') {
            unset($rules['password']);
            unset($rules['password_confirmation']);
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->user->id;
        }

        return $rules;
    }
}
