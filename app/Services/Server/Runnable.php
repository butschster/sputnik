<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Services\Task\Contracts\Task;
use App\Utils\SSH\Contracts\Script;

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
     * @return Task
     */
    protected function run(Script $script, array $options = []): Task
    {
        $task = $this->tasksFactory->createFromScript($this->server, $script, $options);

        $this->executorService->run(
            $task
        );

        return $task->refresh();
    }

    /**
     * @param Script $script
     * @param array $options
     * @return Task
     */
    protected function runInBackground(Script $script, array $options = []): Task
    {
        $task = $this->tasksFactory->createFromScript($this->server, $script, $options);

        $this->executorService->runInBackground(
            $task
        );

        return $task;
    }
}
