<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function storeRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:products,name',
            'description' => 'nullable|string|min:3|max:600',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'stock_quantity' => 'required|integer|min:1|max:9999',
            'Category' => 'required',
            'Berand' => 'required',
        ];
    }
    public function updateRules($id): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:products,name,'.$id,
            'description' => 'nullable|string|min:3|max:600',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock_quantity' => 'required|integer|min:1|max:9999',
            'Category' => 'required',
            'Berand' => 'required',
        ];
    }
}
