<?php

namespace App\Events\Action;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Lorisleiva\Actions\Action;

class Executed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Action
     */
    public $action;

    /**
     * Create a new event instance.
     *
     * @param Action $action
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
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
