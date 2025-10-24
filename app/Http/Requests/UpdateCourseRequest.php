<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'title' => 'bail|required|string|min:2|max:255',
            'description' => 'bail|required|string|min:2',
            'img_file' => 'bail|image|size:5120|mimes:jpg,jpeg,png',
            'priority' => 'bail|integer|min:1|max:100',
            'price' => 'bail|integer|min:0|max:100000000',
            'duration' => 'bail|integer|min:0|max:100000000',
            'visibility' => 'bail|required|boolean',
        ];
    }
}
