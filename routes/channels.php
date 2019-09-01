<?php

use App\Models\Server;
use App\Models\User;

Broadcast::channel('server.{server}', function (User $user, Server $server) {
    return $user->canManageServer($server);
});
