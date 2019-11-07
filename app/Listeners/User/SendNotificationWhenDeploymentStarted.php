<?php

namespace App\Listeners\User;

use App\Events\Server\Deployment\Running;

class SendNotificationWhenDeploymentStarted
{
    public function handle(Running $event)
    {
        $event->deployment->server->user->notify(
            new \App\Notifications\Server\Deployment\Running($event->deployment)
        );
    }
}