<?php

namespace App\Listeners\User;

use App\Events\Server\Alert\Created;
use App\Notifications\Server\Alert\Created as Notifictation;

class SendNotificationWhenAlertCreated
{
    /**
     * @param Created $event
     */
    public function handle(Created $event)
    {
        $event->alert->server->user->notify(
            new Notifictation($event->alert)
        );
    }
}