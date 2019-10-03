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
     * Register a new filter
     *
     * @param string $key
     * @param string $filter
     */
    public function registerFilter(string $key, string $filter): void
    {
        $this->filters[$key] = $filter;
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