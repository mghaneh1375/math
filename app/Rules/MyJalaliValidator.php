<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Hekmatinasser\Verta\Verta;
use Exception;

class MyJalaliValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return false;
        }
        $format = 'Y/m/d';

        // try {
        //     Verta::parseFormat($format, $value);
        // } catch (Exception $e) {
        //     return false;
        // }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'تاریخ وارد شده نامعتبر است';
    }
}
