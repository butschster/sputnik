<?php

namespace Domain\Site\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class PublicPath implements Rule
{
    const REGEX = "/^\/([\w\/]+)?$/";

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match(static::REGEX, $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute contains not a valid public path';
    }
}
