<?php

namespace App\Policies;

use App\Models\OpenVPNServer;
use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OpenVPNClientPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param OpenVPNServer $server
     * @return bool
     */
    public function store(?User $user, OpenVPNServer $server): bool
    {
        if (!$server->isConfigured()) {
            return false;
        }

        return $user->canManageServer($server);
    }

    /**
     * @param User|null $user
     * @param Server\OpenVPN\Client $client
     * @return bool
     */
    public function show(?User $user, Server\OpenVPN\Client $client): bool
    {
        return $user->canManageServer($client->server);
    }

    /**
     * @param User|null $user
     * @param Server\OpenVPN\Client $client
     * @return bool
     */
    public function delete(?User $user, Server\OpenVPN\Client $client): bool
    {
        return $user->canManageServer($client->server);
    }
}