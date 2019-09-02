<?php

namespace App\Events\Task;

use App\Http\Resources\v1\Server\TaskResource;
use App\Models\Server\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangedStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Task
     */
    public $task;

    /**
     * This event fires when remove server sent callback about finished task
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the channels the event should broadcast on.
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return new PrivateChannel('server.' . $this->task->server_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['task' => TaskResource::make($this->task)];
    }
}
