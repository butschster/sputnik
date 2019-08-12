<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerPublicKeyPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user can create public keys for the given server
     *
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function store(User $user, Server $server): bool
    {
        return $user->id === $server->user_id;
    }

    /**
     * Check if user can delete public keys for the given server
     *
     * @param User $user
     * @param Server\PublicKey $key
     *
     * @return bool
     */
    public function delete(User $user, Server\PublicKey $key): bool
    {
        return $user->id === $key->server->user_id;
    }
}
