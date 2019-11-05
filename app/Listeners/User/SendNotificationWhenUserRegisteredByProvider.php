<?php

namespace App\Listeners\User;

use Domain\SourceProvider\Events\Registered;

class SendNotificationWhenUserRegisteredByProvider
{
    /**
     * @param Registered $event
     */
    public function handle(Registered $event)
    {
        $event->user->notify(
            new \App\Notifications\User\RegisteredByProvider(
                $event->password
            )
        );
    }

}