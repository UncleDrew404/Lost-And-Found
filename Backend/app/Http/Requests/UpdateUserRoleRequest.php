<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('roles.assign') ?? false;
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', Rule::in(['admin', 'staff', 'student'])],
        ];
    }
}
