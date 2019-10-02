<?php

namespace Module\OpenVPN\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Module\OpenVPN\Models\Client;

class ClientPolicy
{
    use HandlesAuthorization;

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

        return $user->canManageServer($server);
    }

    /**
     * @param User|null $user
     * @param Client $client
     * @return bool
     */
    public function show(?User $user, Client $client): bool
    {
        return $user->canManageServer($client->server);
    }

    /**
     * @param User|null $user
     * @param Client $client
     * @return bool
     */
    public function delete(?User $user, Client $client): bool
    {
        return $user->canManageServer($client->server);
    }
}