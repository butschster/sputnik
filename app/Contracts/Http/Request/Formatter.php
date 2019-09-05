<?php

namespace App\Contracts\Http\Request;

interface Formatter
{
    /**
     *  Return the result of applying this filter to the given input.
     *
     * @param mixed $value
     * @param array $options
     * @return mixed
     */
    public function apply($value, array $options = []);
}