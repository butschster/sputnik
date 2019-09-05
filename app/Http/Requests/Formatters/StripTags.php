<?php

namespace App\Http\Requests\Formatters;

use App\Contracts\Http\Request\Formatter;

class StripTags implements Formatter
{
    /**
     *  Strip tags from the given string.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function apply($value, array $options = [])
    {
        return is_string($value) ? strip_tags($value) : $value;
    }
}