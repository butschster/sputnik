<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerCronJobPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Server\CronJob $job
     * @return bool
     */
    public function show(?User $user, Server\CronJob $job): bool
    {
        return $user->canManageServer($job->server);
    }

    /**
     * Check if user can create public keys for the given server
     *
     * @param User $user
     * @param Server $server
     * @return bool
     */
    public function store(User $user, Server $server): bool
    {
        if (!$server->isConfigured()) {
            return false;
        }

        return $user->canManageServer($server) &&
            $user->canUseFeature('server.cron_job.create');
    }

    /**
     * Check if user can delete cron jobs for the given server
     *
     * @param User $user
     * @param Server\CronJob $job
     *
     * @return bool
     */
    public function delete(User $user, Server\CronJob $job): bool
    {
        return $user->canManageServer($job->server);
    }
}
