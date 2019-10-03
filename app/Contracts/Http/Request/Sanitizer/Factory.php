<?php

namespace App\Contracts\Http\Request\Sanitizer;

use App\Http\Requests\Sanitizer;

interface Factory
{
    /**
     * Register a new filter
     *
     * @param string $key
     * @param string $filter
     */
    public function registerFilter(string $key, string $filter): void;

    /**
     * Create a new Sanitizer instance
     *
     * @param array $data
     * @param array $rules
     * @return Sanitizer
     */
    public function make(array $data, array $rules): Sanitizer;
}