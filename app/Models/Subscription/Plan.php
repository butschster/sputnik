<?php

namespace App\Models\Subscription;

use Rinvex\Subscriptions\Models\Plan as BasePlan;

class Plan extends BasePlan
{
    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [];

    protected static function bootHasSlug()
    {

    }

}