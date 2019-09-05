<?php

namespace App\Http\Requests\Sanitizer;

use App\Contracts\Http\Request\Sanitizer\Factory as FactoryContract;
use App\Http\Requests\Sanitizer;

class Factory implements FactoryContract
{
    /**
     * @var array
     */
    protected $filters;

    /**
     * @param array $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Create a new Sanitizer instance
     *
     * @param array $data
     * @param array $rules
     * @return Sanitizer
     */
    public function make(array $data, array $rules): Sanitizer
    {
        return new Sanitizer($data, $rules, $this->filters);
    }
}