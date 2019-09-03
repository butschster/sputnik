<?php

namespace App\Http\Requests\Formatters;

use App\Contracts\Http\Request\Formatter;

class Digit implements Formatter
{
    /**
     *  Get only digit characters from the string.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function apply($value, array $options = [])
    {
        return preg_replace('/[^0-9]/si', '', $value);
    }
}