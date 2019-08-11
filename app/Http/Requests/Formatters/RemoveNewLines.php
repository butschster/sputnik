<?php

namespace App\Http\Requests\Formatters;

use Waavi\Sanitizer\Contracts\Filter;

class RemoveNewLines implements Filter
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
        return str_replace([PHP_EOL, "\r"], '', $value);
    }
}

