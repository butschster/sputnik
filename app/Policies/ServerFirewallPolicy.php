<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServerFirewallPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     * @param Server\Firewall\Rule $rule
     * @return bool
     */
    public function show(?User $user, Server\Firewall\Rule $rule): bool
    {
        return $rule->server->user_id == $user->id;
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

        return $server->user_id == $user->id;
    }

    /**
     * @param User|null $user
     * @param Server\Firewall\Rule $rule
     * @return bool
     */
    public function delete(?User $user, Server\Firewall\Rule $rule): bool
    {
        return $rule->server->user_id == $user->id;
    }
}
