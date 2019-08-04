<?php

namespace App\Services\Server\Callbacks;

use App\Models\Server\Task;

class MarkAsConfigured
{
    /**
     * Handle the callback.
     *
     * @param Task $task
     * @return void
     */
    public function handle(Task $task)
    {
        if ($task->server) {
            $task->server->markAsConfigured();
        }
    }
}
