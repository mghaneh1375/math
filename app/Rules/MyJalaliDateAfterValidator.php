<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Hekmatinasser\Verta\Verta;
use Exception;

class MyJalaliDateAfterValidator implements Rule
{

    private $date;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        $this->date = $date;
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
        //     $base = Verta::parseFormat($format, $this->date);
        //     return Verta::parseFormat($format, $value)->gt($base);
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'تاریخ باید بعد از ' .$this->date . ' باشد';
    }
}
