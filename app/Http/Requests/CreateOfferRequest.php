<?php

namespace App\Http\Requests;

use App\Enums\OffCodeType;
use App\Rules\MyJalaliDateAfterValidator;
use App\Rules\MyJalaliValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CreateOfferRequest extends FormRequest
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
            'type' => ['bail', 'required', Rule::in([OffCodeType::PERCENT, OffCodeType::VALUE])],
            'value' => 'bail|required|integer|min:1|max:9999999999',
            'code' => 'bail|string|min:5|max:10',
            'course_id' => ['bail', 'integer', 'min:1', 'exists:courses,id'],
            'lesson_id' => ['bail', 'integer', 'min:1', 'exists:lessons,id'],
            'grade_id' => ['bail', 'integer', 'min:1', 'exists:grades,id'],
            'expire_at' => ['nullable', new MyJalaliValidator, new MyJalaliDateAfterValidator(self::getToday())],
        ];
    }
}
