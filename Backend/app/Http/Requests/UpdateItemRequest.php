<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'type' => ['sometimes', Rule::in(['lost', 'found'])],
            'status' => ['sometimes', Rule::in(['active', 'resolved'])],
            'location' => ['sometimes', 'string', 'max:255'],
            'date_occured' => ['sometimes', 'date'],
            'contact_info' => ['sometimes', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
