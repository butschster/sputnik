<?php

use App\Models\Server;
use App\Models\User;

Broadcast::channel('users.{id}', function (User $user, string $id) {
    return $user->id === $id;
});


Broadcast::channel('server.{server}', function (User $user, Server $server) {
    return $user->canManageServer($server);
});
