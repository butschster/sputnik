<?php

namespace App\Observers\Server\User;

use App\Models\Server\User;
use App\Services\Server\UserService;

class SyncUserObserver
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * SyncUserObserver constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param User $user
     */
    public function created(User $user): void
    {
        if (!$user->isSystem()) {
            $this->service->create($user);
        }
    }

    /**
     * @param User $user
     */
    public function deleted(User $user): void
    {
        if (!$user->isSystem()) {
            $this->service->delete($user);
        }
    }
}
