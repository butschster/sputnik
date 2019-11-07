<?php

namespace App\Listeners\User;

use App\Events\Server\Deleted;
use App\Notifications\Server\Deleted as Notification;

class SendNotificationWhenServerDeleted
{
    public function handle(Deleted $event)
    {
        $event->server->user->notify(
            new Notification($event->server)
        );
    }
}