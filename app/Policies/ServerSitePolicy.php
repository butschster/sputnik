<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\Server\Site;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerSitePolicy
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

        return $server->user_id == $user->id &&
            $user->canUseFeature('server.site.create');
    }

    /**
     * @param User|null $user
     * @param Site $site
     * @return bool
     */
    public function deploy(?User $user, Site $site): bool
    {
        if (!$site->server->isConfigured()) {
            return false;
        }

        return $site->server->user_id == $user->id &&
            $user->canUseFeature('server.deployments');
    }


    /**
     * @param User|null $user
     * @param Site $site
     * @return bool
     */
    public function pushDeploy(?User $user, Site $site): bool
    {
        if (!$site->server->isConfigured()) {
            return false;
        }

        return $site->server->user_id == $user->id &&
            $user->canUseFeature('server.deployments.push');
    }


    /**
     * @param User|null $user
     * @param Site $site
     * @return bool
     */
    public function update(?User $user, Site $site): bool
    {
        return $site->server->user_id == $user->id;
    }


    /**
     * @param User|null $user
     * @param Site $site
     * @return bool
     */
    public function show(?User $user, Site $site): bool
    {
        return $site->server->user_id == $user->id;
    }

    /**
     * @param User|null $user
     * @param Site $site
     * @return bool
     */
    public function delete(?User $user, Site $site): bool
    {
        return $site->server->user_id == $user->id;
    }
}
