<?php

namespace App\Scripts\Server;

use App\Utils\SSH\Script;

class Task extends Script
{
    /**
     * @var \App\Services\Task\Contracts\Task
     */
    protected $task;

    /**
     * @var string
     */
    protected $name = 'Callback from server';

    /**
     * @param \App\Services\Task\Contracts\Task $task
     */
    public function __construct(\App\Services\Task\Contracts\Task $task)
    {
        $this->task = $task;
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
            'task' => $this->task
        ])->render();
    }
}
