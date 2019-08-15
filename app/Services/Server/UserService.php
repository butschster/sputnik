<?php

namespace App\Services\Server;

use App\Models\Server\User;
use App\Scripts\Server\User\Create;
use App\Scripts\Server\User\Delete;
use App\Services\Task\Contracts\Task;

class UserService
{
    use Runnable;

    /**
     * @param User $user
     *
     * @return Task
     */
    public function create(User $user): Task
    {
        $this->setServer($user->server);
        $this->setOwner($user);

        return $this->runJob(new Create($user));
    }

    /**
     * @param User $user
     *
     * @return Task
     */
    public function delete(User $user): Task
    {
        $this->setServer($user->server);
        $this->setOwner($user);

        return $this->runJob(new Delete($user));
    }
}
