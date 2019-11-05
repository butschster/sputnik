<?php

namespace App\Listeners\User;

use Domain\SourceProvider\Events\Disconnected;

class SendNotificationWhenProviderDisconnected
{
    /**
     * @param Disconnected $event
     */
    public function handle(Disconnected $event)
    {
        $event->user->notify(
            new \App\Notifications\User\SourceProvider\Disconnected(
                $event->provider
            )
        );
    }
}