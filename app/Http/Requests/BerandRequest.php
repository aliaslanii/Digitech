<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BerandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function storeRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:berands,name',
            'description' => 'nullable|string|min:3|max:600',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
    public function updateRules($id): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:berands,name,'.$id,
            'description' => 'nullable|string|min:3|max:600',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }   
}
