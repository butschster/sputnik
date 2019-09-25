<?php

namespace App\Events\Server\Module;

use App\Models\Server;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Started implements ShouldBroadcast
{
    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     * @param string $module
     */
    public function __construct(Server $server, string $module)
    {
        $this->server = $server;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return new PrivateChannel('server.' . $this->server->id);
    }
}