<?php

namespace App\Events\Subscription\Feature;

use App\Models\Subscription\Plan\Feature;

class Used
{
    /**
     * @var Feature
     */
    public $feature;

    /**
     * @param Feature $feature
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }
}