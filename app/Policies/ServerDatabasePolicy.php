<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use App\Models\Server\Database;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerDatabasePolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Database $database
     * @return bool
     */
    public function show(?User $user, Database $database): bool
    {
        return $database->server->user_id == $user->id;
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

        return $server->user_id == $user->id &&
            $user->canUseFeature('server.database.create');
    }

    /**
     * @param User|null $user
     * @param Database $database
     * @return bool
     */
    public function delete(?User $user, Database $database): bool
    {
        return $database->server->user_id == $user->id;
    }
}
