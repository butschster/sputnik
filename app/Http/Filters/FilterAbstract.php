<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

abstract class FilterAbstract
{

    /**
     * @param Builder $builder
     * @param mixed $value
     *
     * @return Builder
     */
    abstract public function filter(Builder $builder, $value);

    public function defaultValue()
    {

    }

    /**
     * Database value mappings.
     * @return array
     */
    protected function mappings()
    {
        return [];
    }

    /**
     * Resolve the value used for filtering.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    protected function resolveFilterValue($key)
    {
        if (is_null($key)) {
            return;
        }

        return Arr::get($this->mappings(), $key);
    }

    /**
     * Resolve the order direction to be used.
     *
     * @param string $direction
     *
     * @return string
     */
    protected function resolveOrderDirection($direction)
    {
        return Arr::get([
            'desc' => 'desc',
            'asc' => 'asc',
        ], $direction, 'desc');
    }
}
