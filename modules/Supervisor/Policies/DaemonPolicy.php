<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Module\Supervisor\Models\Daemon;

class DaemonPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Daemon $daemon
     * @return bool
     */
    public function show(?User $user, Daemon $daemon): bool
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
     * @param Daemon $daemon
     * @return bool
     */
    public function delete(?User $user, Daemon $daemon): bool
    {
        return $user->canManageServer($daemon->server);
    }
}
