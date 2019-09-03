<?php

namespace App\Http\Requests\Formatters;

use App\Contracts\Http\Request\Formatter;

class Capitalize implements Formatter
{
    /**
     *  Capitalize the given string.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function apply($value, array $options = [])
    {
        return is_string($value) ? ucwords(strtolower($value)) : $value;
    }
}