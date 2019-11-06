<?php

namespace App\Listeners\User;

use App\Events\Server\Deployment\Running;

class SendNotificationWhenDeploymentStarted
{
    public function handle(Running $event)
    {
        $event->deployment->server->user->notify(

        );
    }
}