<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\Server\Site;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerTaskPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Server\Task $task
     * @return bool
     */
    public function show(?User $user, Server\Task $task): bool
    {
        return $user->canManageServer($task->server);
    }

    /**
     * @param User|null $user
     * @param Server\Task $task
     * @return bool
     */
    public function delete(?User $user, Server\Task $task): bool
    {
        return false;
    }
}
