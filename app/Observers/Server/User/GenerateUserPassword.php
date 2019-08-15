<?php

namespace App\Observers\Server\User;

use App\Models\Server\User;
use Illuminate\Support\Str;

class GenerateUserPassword
{
    /**
     * @param User $user
     */
    public function creating(User $user): void
    {
        $user->sudo_password = Str::random();
    }
}
