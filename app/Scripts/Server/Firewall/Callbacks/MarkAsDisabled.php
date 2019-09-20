<?php

namespace App\Scripts\Server\Firewall\Callbacks;

use App\Contracts\Scripts\Callback;
use App\Models\Server\Task;

class MarkAsDisabled implements Callback
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
        $meta = $task->server->meta;
        $meta['firewall'] = 'disabled';
        $task->server->meta = $meta;
        $task->server->save();
    }
}