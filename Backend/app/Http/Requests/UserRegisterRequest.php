<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users', // Added unique check
            'password' => 'required|string|min:8',    // Added min length
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }
}
