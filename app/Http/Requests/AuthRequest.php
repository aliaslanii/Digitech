<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function registerRole(): array
    {
        return [
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile|min:11|max:13',
            'email' => 'email|unique:users,email',
            'password' => 'required|min:8|regex:/[A-Z]/|confirmed'
        ];
    }
    public function loginRole(): array
    {
        return [
            'mobile' => 'required|min:11|max:13',
            'password' => 'required'
        ];
    }
}
