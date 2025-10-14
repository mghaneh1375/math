<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseSessionRequest extends FormRequest
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
            'duration' => 'bail|required|integer',
            'chapter' => 'bail|required|string|min:2|max:255',
            'description' => 'bail|string|min:2|max:10000',
            'link' => 'bail|nullable|string|url:http,https',
            'visibility' => 'bail|required|boolean'
        ];
    }
}
