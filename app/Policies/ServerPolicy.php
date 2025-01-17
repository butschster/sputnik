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
     * @return bool
     */
    public function create(?User $user): bool
    {
        return $user->can('server.create') &&
            $user->canUseFeature('server.create');
    }


    /**
     * @param User|null $user
     * @param User\Team $team
     * @return bool
     */
    public function store(?User $user, User\Team $team): bool
    {
        return $user->can('server.create', $team) &&
            $user->canUseFeature('server.create');
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
    public function update(?User $user, Server $server): bool
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
        return (
            $server->user_id == $user->id
            || $user->can('server.delete', $server->team)
        );
    }

    /**
     * @param User|null $user
     * @param Server $server
     * @return bool
     */
    public function enableFirewall(?User $user, Server $server): bool
    {
        return !$server->toConfiguration()->firewallStatus() && $user->canManageServer($server);
    }

    /**
     * @param User|null $user
     * @param Server $server
     * @return bool
     */
    public function disableFirewall(?User $user, Server $server): bool
    {
        return $server->toConfiguration()->firewallStatus() && $user->canManageServer($server);
    }
}
