<?php

namespace App\Events\Server\Ping;

use App\Models\Server;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Checked implements ShouldBroadcast
{
    /**
     * @var Server
     */
    public $server;

    /**
     * @var bool
     */
    public $status;

    /**
     * @param Server $server
     * @param bool $status
     */
    public function __construct(Server $server, bool $status)
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
        return new PrivateChannel('server.' . $this->server->id);
    }
}