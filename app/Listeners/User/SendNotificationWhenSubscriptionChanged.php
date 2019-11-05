<?php

namespace App\Listeners\User;

use App\Events\Subscription\Subscribed;
use App\Notifications\User\Subscription\Changed;

class SendNotificationWhenSubscriptionChanged
{
    /**
     * @param Subscribed $event
     */
    public function handle(Subscribed $event)
    {
        $event->subscription->user->notify(
            new Changed($event->subscription)
        );
    }
}