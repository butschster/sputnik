<?php

namespace App\Listeners\User;

use Illuminate\Auth\Events\Registered;

class SendNotificationWhenUserRegistered
{
    /**
     * @param Registered $event
     */
    public function handle(Registered $event)
    {
        $event->user->notify(
            new \App\Notifications\User\Registered()
        );
    }

}