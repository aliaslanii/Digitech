<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
    public function storeRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:categories,name',
            'description' => 'nullable|string|min:3|max:600',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    public function updateRules($id): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:categories,name,'.$id,
            'description' => 'nullable|string|min:3|max:600',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
