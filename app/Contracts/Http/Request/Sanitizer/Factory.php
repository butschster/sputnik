<?php

namespace App\Contracts\Http\Request\Sanitizer;

use App\Http\Requests\Sanitizer;

interface Factory
{
    /**
     * Create a new Sanitizer instance
     *
     * @param array $data
     * @param array $rules
     * @return Sanitizer
     */
    public function make(array $data, array $rules): Sanitizer;
}