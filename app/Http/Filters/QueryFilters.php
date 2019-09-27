<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

abstract class QueryFilters
{
    use ValidatesRequests;

    /**
     * The request object.
     * @var Request
     */
    protected $request;

    /**
     * The builder instance.
     * @var Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new QueryFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Instantiate a filter.
     *
     * @param  string $filter
     *
     * @return mixed
     */
    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }

    /**
     * Get filters to be used.
     * @return array
     */
    protected function getCustomFilters()
    {
        return $this->filters;
    }

    /**
     * Filter filters that are only in the request.
     *
     * @param  array $filters
     *
     * @return array
     */
    protected function filterFilters($filters)
    {
        return $this->filters;
    }

    /**
     * Apply the filters to the builder.
     *
     * @param  Builder $builder
     *
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }

            if (is_array($value) or trim($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        foreach ($this->getCustomFilters() as $filter => $class) {
            $filterObject = $this->resolveFilter($filter);

            $value = $this->request->input($filter) ?? $filterObject->defaultValue();

            if ($value) {
                $filterObject->filter($builder, $value);
            }
        }

        return $this->builder;
    }

    /**
     * Get all request filters data.
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }
}
