<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Mobile implements Rule
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
        // for empty value return true
        // because sometimes we may have nullable field
        if (empty($value)) {
            return true;
        }

        // check if has 10 digits
        // if (Validator::make(['mobile' => $value], ['mobile' => 'digits:10'])->fails()) {
        //     logger('not all nums');
        //     return false;
        // }

        // must have exactly has 10 integer digits
        if (!preg_match('/^[0-9]{10}$/', $value)) {
            logger('Mobile validation failed: Do not have exactly 10 digits');
            return false;
        }

        // must start with 98
        if (substr($value, 0, 2) != '98') {
            logger('Mobile validation failed: Do not start with 98');
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid mobile number.';
    }
}
