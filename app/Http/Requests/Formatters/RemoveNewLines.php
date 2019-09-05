<?php

namespace App\Http\Requests\Formatters;

use App\Contracts\Http\Request\Formatter;

class RemoveNewLines implements Formatter
{
    /**
     *  Return the result of applying this filter to the given input.
     *
     * @param mixed $value
     * @param array $options
     *
     * @return mixed
     */
    public function apply($value, array $options = [])
    {
        return str_replace([PHP_EOL, "\r"], '', $value);
    }
}

