<?php

namespace App\Listeners\User;

use Domain\SourceProvider\Events\Connected;

class SendNotificationWhenProviderConnected
{
    /**
     * @param Connected $event
     */
    public function handle(Connected $event)
    {
        $event->user->notify(
            new \App\Notifications\User\SourceProvider\Connected(
                $event->provider
            )
        );
    }
}