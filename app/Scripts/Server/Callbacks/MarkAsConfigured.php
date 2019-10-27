<?php

namespace App\Scripts\Server\Callbacks;

use App\Models\Server\Task;
use Domain\Task\Contracts\Script\Callback;

class MarkAsConfigured implements Callback
{
    /**
     * When the task "Configuring Web Server" is finished it runs this callback
     * and the server changes status to finished
     *
     * @param Task $task
     * @return void
     */
    public function handle(Task $task): void
    {
        $task->server->markAsConfigured();
    }
}
