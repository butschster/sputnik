<?php

namespace Domain\SourceProvider\Events;

use App\Models\User;

class Registered
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
     * @var string
     */
    public $password;

    /**
     * @param string $provider
     * @param User $user
     * @param string $password
     */
    public function __construct(string $provider, User $user, string $password)
    {
        $this->provider = $provider;
        $this->user = $user;
        $this->password = $password;
    }
}