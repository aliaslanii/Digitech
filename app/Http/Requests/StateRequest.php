<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function storeRules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:states,name',
        ];
    }
    public function updateRoles($id): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:states,name,'.$id,
        ];
    }
}
