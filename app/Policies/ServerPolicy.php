<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Server $server
     * @return bool
     */
    public function installKeys(?user $user, Server $server)
    {
        return $server->isPending();
    }

    /**
     * @param User|null $user
     *
     * @return bool
     */
    public function store(?User $user): bool
    {
        return $user->canUseFeature('server.create');
    }

    /**
     * @param User|null $user
     * @param Server $server
     * @return bool
     */
    public function show(?User $user, Server $server): bool
    {
        return $user->canManageServer($server);
    }

    /**
     * @param User|null $user
     * @param Server $server
     * @return bool
     */
    public function delete(?User $user, Server $server): bool
    {
        return $user->can('server.delete', $server->team);
    }
}
