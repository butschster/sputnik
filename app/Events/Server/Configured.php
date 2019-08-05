<?php

namespace App\Events\Server;

use App\Models\Server;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Configured
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Server
     */
    public $server;

    /**
     * This event fires when remove server is configured
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }
}
