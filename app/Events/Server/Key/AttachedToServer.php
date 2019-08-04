<?php

namespace App\Events\Server\Key;

use App\Models\Server;
use App\Models\Server\Key;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttachedToServer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Key
     */
    public $key;

    /**
     * @var Server
     */
    public $server;

    /**
     * Create a new event instance.
     *
     * @param Server $server
     * @param Key $key
     */
    public function __construct(Server $server, Key $key)
    {
        $this->key = $key;
        $this->server = $server;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
