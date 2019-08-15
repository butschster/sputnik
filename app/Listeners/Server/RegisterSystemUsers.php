<?php

namespace App\Listeners\Server;

use App\Events\Server\Created;
use App\Models\Server\User;

class RegisterSystemUsers
{
    /**
     * @param Created $event
     */
    public function handle(Created $event)
    {
        $server = $event->server;

        $server->users()->create([
            'name' => 'root',
            'home_dir' => '/root',
            'is_system' => true,
        ]);

        $server->users()->create([
            'name' => 'sputnik',
            'is_system' => true,
            'sudo' => true
        ]);
    }
}
