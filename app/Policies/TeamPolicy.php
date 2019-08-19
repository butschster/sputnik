<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param User\Team $team
     * @return bool
     */
    public function show(User $user, User\Team $team): bool
    {
        return $user->hasRole(['owner', 'member'], $team);
    }

    /**
     * @param User $user
     * @param User\Team $team
     * @return bool
     */
    public function invite(User $user, User\Team $team): bool
    {
        return $user->can('team.manage', $team);
    }

    /**
     * @param User $user
     * @param User\Team $team
     * @return bool
     */
    public function cancelSubscription(User $user, User\Team $team): bool
    {
        return $user->can('subscriptions.manage', $team)
            && $user->hasActiveSubscription();
    }

    /**
     * @param User $user
     * @param User\Team $team
     * @return bool
     */
    public function subscribe(User $user, User\Team $team): bool
    {
        return $user->can('subscriptions.manage', $team);
    }
}