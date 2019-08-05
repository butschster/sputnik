<?php

namespace App\Events\Task;

use App\Models\Server\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Response
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Task
     */
    public $task;

    /**
     * @var \App\Utils\SSH\Shell\Response
     */
    public $response;

    /**
     * Create a new event instance.
     *
     * @param Task $task
     * @param \App\Utils\SSH\Shell\Response $response
     */
    public function __construct(Task $task, \App\Utils\SSH\Shell\Response $response)
    {
        $this->task = $task;
        $this->response = $response;
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
