<?php

namespace App\Policies\Server;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Server\Record $record
     * @return bool
     */
    public function show(?User $user, Server\Record $record): bool
    {
        return $user->canManageServer($record->server);
    }

    /**
     * @param User|null $user
     * @param Server $server
     * @param string $feature
     * @return bool
     */
    public function store(?User $user, Server $server, string $feature = 'server.record.create'): bool
    {
        if (!$server->isConfigured()) {
            return false;
        }

        return $user->canManageServer($server) &&
            $user->canUseFeature($feature);
    }

    /**
     * @param User|null $user
     * @param Server\Record $record
     * @return bool
     */
    public function delete(?User $user, Server\Record $record): bool
    {
        return $user->canManageServer($record->server);
    }
}