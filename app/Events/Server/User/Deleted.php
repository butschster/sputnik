<?php

namespace App\Events\Server\User;

use App\Models\Server;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Deleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Server\User
     */
    public $user;

    /**
     * @param Server\User $user
     */
    public function __construct(Server\User $user)
    {
        $this->user = $user;
    }
}

