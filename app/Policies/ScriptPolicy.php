<?php

namespace App\Policies;

use App\Models\Script;
use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScriptPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     *
     * @return bool
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * @param User|null $user
     * @param Script $script
     *
     * @return mixed
     */
    public function show(?User $user, Script $script)
    {
        return $script->user->is($user);
    }

    /**
     * @param User|null $user
     * @param Script $script
     *
     * @return mixed
     */
    public function update(?User $user, Script $script)
    {
        return $script->user->is($user);
    }

    /**
     * @param User|null $user
     * @param Script $script
     * @param Server $server
     *
     * @return bool
     */
    public function execute(?User $user, Script $script, Server $server): bool
    {
        if (!$user->canManageServer($server)) {
            return false;
        }

        if (!$script->canBeRunOnServer($server)) {
            return false;
        }

        return $script->public || $script->user->is($user);
    }

    /**
     * @param User|null $user
     * @param Script $script
     *
     * @return bool
     */
    public function delete(?User $user, Script $script): bool
    {
        return $script->user->is($user);
    }
}
