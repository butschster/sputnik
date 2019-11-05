<?php

namespace Domain\SourceProvider\Events;

use App\Models\User;

class Disconnected
{
    /**
     * @var string
     */
    public $provider;

    /**
     * @var User
     */
    public $user;

    /**
     * @param string $provider
     * @param User $user
     */
    public function __construct(string $provider, User $user)
    {
        $this->provider = $provider;
        $this->user = $user;
    }
}