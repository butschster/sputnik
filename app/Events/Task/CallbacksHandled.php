<?php

namespace App\Events\Task;

use App\Models\Server\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallbacksHandled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Task
     */
    public $task;

    /**
     * @var array
     */
    public $callbacks;

    /**
     * This event fires when remove server sent callback about finished task
     *
     * @param Task $task
     * @param array $callbacks
     */
    public function __construct(Task $task, array $callbacks)
    {
        $this->task = $task;
        $this->callbacks = $callbacks;
    }
}