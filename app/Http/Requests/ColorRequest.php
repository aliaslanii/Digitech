<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function storeRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:colors,name',
            'color' => 'required|string|min:3|max:50|unique:colors,color',
        ];
    }
    public function updateRules($id): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:colors,name,'.$id,
            'color' => 'required|string|min:3|max:50|unique:colors,color,'.$id,
        ];
    }
}

