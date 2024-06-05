<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressCustomerRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'mobile' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:500',
            'states_id' => 'required',
            'cities_id' => 'required',
            'zipCode' => 'required|string|min:13|max:14',
            'plate' => 'required|string|min:3|max:255',
            'unit' => 'required|string|min:3|max:255',
            'user_id' => 'required',
        ];
    }
}
