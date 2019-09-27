<?php

namespace App\Http\Filters\Ordering;

use App\Http\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class CreatedAtOrder extends FilterAbstract
{
    /**
     * @return string|void
     */
    public function defaultValue()
    {
        return 'desc';
    }

    /**
     * @param Builder $builder
     * @param mixed $direction
     *
     * @return Builder
     */
    public function filter(Builder $builder, $direction)
    {
        $direction = $this->resolveOrderDirection($direction);

        return $builder->orderBy('created_at', $direction);
    }
}