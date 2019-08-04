<?php

namespace App\Scripts\Server;

use App\Models\Server\Task;
use App\Utils\Hashids;
use App\Utils\Ssh\Script;
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
     */
    public function getScript(): string
    {
        return view('scripts.tools.callback', [
            'task' => $this->task,
            'path' => str_replace('.sh', '-script.sh', $this->task->scriptFile()),
            'token' => Str::random(20),
            'hash' => (new Hashids())->encode($this->task->id),
        ])->render();
    }
}
