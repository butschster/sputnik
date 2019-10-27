<?php

namespace App\Scripts\Server\User;

use App\Models\Server\User;
use Domain\SSH\Script;

class Delete extends Script
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Create constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the contents of the script.
     * @return string
     */
    public function getScript(): string
    {
        return view('scripts.server.user.delete', [
            'user' => $this->user,
        ]);
    }
}
