<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'bail|required|string|min:2|max:100',
            'lastname' => 'bail|required|string|min:2|max:100',
            'username' => ['bail', 'required', 'regex:/^09\d{9}$/'],
            'password' => 'bail|required|min:3|max:50',
            'school_name' => 'bail|string|min:2|max:100',
            'grade_id' => ['bail']
        ];
    }
}
