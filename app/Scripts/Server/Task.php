<?php

namespace App\Scripts\Server;

use Domain\SSH\Script;

class Task extends Script
{
    /**
     * @var \Domain\Task\Contracts\Task
     */
    protected $task;

    /**
     * @var bool
     */
    protected $callback;

    /**
     * @param \Domain\Task\Contracts\Task $task
     * @param bool $callback
     */
    public function __construct(\Domain\Task\Contracts\Task $task, bool $callback = true)
    {
        $this->task = $task;
        $this->callback = $callback;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('scripts.task', [
            'task' => $this->task,
            'callback' => $this->callback,
        ])->render();
    }
}
