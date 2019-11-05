<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use App\Notifications\Server\SuccessfulyConfigured;

class SendNotificationWhenServerConfigured
{
    /**
     * @param Configured $event
     */
    public function handle(Configured $event)
    {
        $event->server->user->notify(
            new SuccessfulyConfigured($event->server)
        );
    }
}