<?php

namespace App\Validation\Rules\Server;

use App\Services\Server\CronService;
use Illuminate\Contracts\Validation\Rule;

class CronExpression implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return app(CronService::class)->validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not a valid CRON expression';
    }
}
