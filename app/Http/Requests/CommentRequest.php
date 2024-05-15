<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'product_id' => 'required',
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:3|max:600',
            'rating' => 'required',
        ];
    }
}
