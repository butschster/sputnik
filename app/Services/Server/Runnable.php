<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Utils\Ssh\Contracts\Script;

trait Runnable
{
    /**
     * @var Server
     */
    protected $server;

    /**
     * Run the given script on the server.
     *
     * @param Script $script
     * @param array $options
     * @return Server\Task
     */
    protected function run(Script $script, array $options = []): Server\Task
    {
        $task = $this->tasksFactory->createFromScript($this->server, $script, $options);

        $this->runnerService->run(
            $task
        );

        return $task->refresh();
    }

    /**
     * @param Script $script
     * @param array $options
     * @return Server\Task
     */
    protected function runInBackground(Script $script, array $options = []): Server\Task
    {
        $task = $this->tasksFactory->createFromScript($this->server, $script, $options);

        $this->runnerService->runInBackground(
            $task
        );

        return $task;
    }
}
