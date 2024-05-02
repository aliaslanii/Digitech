<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            //
        ];
    }
    public function personalInformationRole(): array
    {
        return [
            'firstName' => 'string|min:3|max:50',
            'lastName' => 'min:3|max:50',
            'birthday' => 'date',
            'gender' =>'in:femail,male',
            'nationalcode' => 'string|min:10|max:11'
        ];
    }
    public function changePasswordRole(): array
    {
        return [
            'now_password' => 'required|string',
            'new_password' => 'required|string|min:8|regex:/[A-Z]/|confirmed',
            'new_password_confirmation' => 'required|string|min:8|regex:/[A-Z]/'
        ];
    }
    public function bankInformationRole(): array
    {
        return [
            "cardnumber" => "min:16|max:16|string",
            "shabanumber" => "min:16|max:24|string"
        ];
    }
    public function changeEmailRole(): array
    {
        return [
            'email' => 'required|email|unique:users,email'
        ];
    }
    public function changeMobileRole(): array
    {
        return [
            'mobile' => "required|min:11|max:11|unique:users,mobile"
        ];
    }
    
}
