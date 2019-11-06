<?php

namespace App\Listeners\User;

use App\Events\Server\Deleted;

class SendNotificationWhenServerDeleted
{
    public function handle(Deleted $event)
    {
        $event->server->user->notify(
            new Deleted($event->server)
        );
    }
}