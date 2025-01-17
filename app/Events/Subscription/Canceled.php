<?php

namespace App\Events\Subscription;

use App\Models\User\Subscription;

class Canceled
{
    /**
     * @var Subscription
     */
    public $subscription;

    /**
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}