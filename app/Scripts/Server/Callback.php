<?php

namespace App\Scripts\Server;

use App\Models\Server\Task;
use Domain\SSH\Script;
use Illuminate\Support\Str;

class Callback extends Script
{
    /**
     * @var Task
     */
    protected $task;

    /**
     * @var string
     */
    protected $name = 'Callback from server';

    /**
     * @param Task $task
     */
    public function __construct(Task $task)
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
        return view('scripts.callback', [
            'task' => $this->task,
            'path' => str_replace('.sh', '-script.sh', $this->task->scriptFile()),
            'token' => Str::random(20),
            'hash' => $this->task->id,
        ])->render();
    }
}
