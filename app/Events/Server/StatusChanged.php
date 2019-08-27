<?php

namespace App\Events\Server;

use App\Models\Server;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StatusChanged implements ShouldBroadcast
{
    /**
     * @var Server
     */
    public $server;

    /**
     * @var string
     */
    public $status;

    /**
     * This event fires when remove server is configured
     *
     * @param Server $server
     * @param string $status
     */
    public function __construct(Server $server, string $status)
    {
        $this->server = $server;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return new Channel('server.' . $this->server->id);
    }
}