<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use App\Models\Server\Database;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerDaemonPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Server\Daemon $daemon
     * @return bool
     */
    public function show(?User $user, Server\Daemon $daemon): bool
    {
        return $user->canManageServer($daemon->server);
    }

    /**
     * @param User|null $user
     * @param Server $server
     * @return bool
     */
    public function store(?User $user, Server $server): bool
    {
        if (!$server->isConfigured()) {
            return false;
        }

        return $user->canManageServer($server) &&
            $user->canUseFeature('server.daemon.create');
    }

    /**
     * @param User|null $user
     * @param Server\Daemon $daemon
     * @return bool
     */
    public function delete(?User $user, Server\Daemon $daemon): bool
    {
        return $user->canManageServer($daemon->server);
    }
}
