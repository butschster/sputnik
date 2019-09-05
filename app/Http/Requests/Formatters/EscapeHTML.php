<?php

namespace App\Http\Requests\Formatters;

use App\Contracts\Http\Request\Formatter;

class EscapeHTML implements Formatter
{
    /**
     *  Remove HTML tags and encode special characters from the given string.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function apply($value, array $options = [])
    {
        return is_string($value) ? filter_var($value, FILTER_SANITIZE_STRING) : $value;
    }
}