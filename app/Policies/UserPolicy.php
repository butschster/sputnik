<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User|null $user
     *
     * @return bool
     */
    public function cancelSubscription(User $user): bool
    {
        return $user->hasActiveSubscription();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function subscribe(User $user): bool
    {
        return true;
    }
}
