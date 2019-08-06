<?php

namespace App\Http\Requests\Formatters;

use App\Services\Server\CronService;

class CronFormatter implements \Waavi\Sanitizer\Contracts\Filter
{
    /**
     *  Return the result of applying this filter to the given input.
     *
     * @param mixed $value
     * @param array $options
     *
     * @return mixed
     */
    public function apply($value, $options = [])
    {
        $service = app(CronService::class);

        if ($service->validate($value)) {
            return $service->parseExpression($value);
        }

        return $value;
    }
}
