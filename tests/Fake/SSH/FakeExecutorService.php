<?php

namespace Tests\Fake\SSH;

use Domain\Task\Contracts\ExecutorService;
use Domain\Task\Contracts\Task;
use Domain\Task\Services\FinishService;
use Domain\SSH\Shell\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FakeExecutorService implements ExecutorService
{
    /**
     * @var Task
     */
    protected $task;

    /**
     * Run task
     *
     * @param Task $task
     */
    public function run(Task $task): void
    {
        $this->task = $task;

        $this->task->markAsRunning();

        app(FinishService::class)->finish($this->task, $this->getOutput($task)->getExitCode());
    }

    /**
     * Run the given script in the background on a remote server by using nohup.
     * https://en.wikipedia.org/wiki/Nohup
     *
     * @param Task $task
     *
     * @throws \Throwable
     */
    public function runInBackground(Task $task): void
    {
        $this->task = $task;

        $this->task->markAsRunning();

        app(FinishService::class)->finish($this->task, $this->getOutput($task)->getExitCode());
    }

    /**
     * @param Task $task
     * @return Response
     */
    protected function getOutput(Task $task): Response
    {
        $output = '';

        if (Str::contains($task->script(), 'pwd')) {
            $output = '/root';
        }

        return new Response(0, $output, false);
    }

}
