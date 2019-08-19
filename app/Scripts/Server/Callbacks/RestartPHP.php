<?php

namespace App\Scripts\Server\Callbacks;

use App\Contracts\Scripts\Callback;
use App\Jobs\Server\RunScript;
use App\Models\Server\Task;
use App\Scripts\Server\CustomScript;

class RestartPHP implements Callback
{
    /**
     * @param Task $task
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     * @throws \Throwable
     */
    public function handle(Task $task): void
    {
        if (!$task->isSuccessful()) {
            return;
        }

        dispatch(new RunScript(
            $task->server,
            new CustomScript('Restart PHP', server_configurator($task->server)->php()->restart())
        ));
    }
}