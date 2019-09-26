<?php

namespace App\Scripts\Server\Callbacks;

use App\Contracts\Scripts\Callback;
use App\Events\Server\Module\Installed;
use App\Models\Server\Task;
use Illuminate\Support\Arr;

class ModuleInstalled implements Callback
{
    /**
     * When the task "Configuring Web Server" is finished it runs this callback
     * and the server changes status to finished
     *
     * @param Task $task
     *
     * @return void
     */
    public function handle(Task $task): void
    {
        $module = Arr::get($task->options(), 'module');

        if (!$module) {
            return;
        }

        event(new Installed($task->server, $module));
    }
}
