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
     * @var \Domain\SSH\Shell\Response
     */
    public $response;

    /**
     * This event fires when remove server sent console output
     *
     * @param Task $task
     * @param \Domain\SSH\Shell\Response $response
     */
    public function __construct(Task $task, \Domain\SSH\Shell\Response $response)
    {
        $this->task = $task;
        $this->response = $response;
    }
}
