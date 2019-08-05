<?php

namespace App\Services\Task;

use App\Services\Task\Contracts\Task;
use App\Utils\SSH\Contracts\ProcessExecutor;

class FinishService
{
    use InteractsWithSsh;

    /**
     * @var $executor
     */
    protected $executor;

    /**
     * @var array
     */
    protected $handledCallbacks = [];

    /**
     * @param ProcessExecutor $executor
     */
    public function __construct(ProcessExecutor $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Mark the task as finished and gather its output.
     *
     * @param Task $task
     * @param int $exitCode
     */
    public function finish(Task $task, int $exitCode = 0)
    {
        $this->task = $task;

        $task->markAsFinished(
            $exitCode,
            $this->retrieveOutput($task)
        );

        $this->runCallbacks($task);
    }

    /**
     * Download the output of the task from the remote server.
     *
     * @param Task $task
     * @return string
     */
    protected function retrieveOutput(Task $task): string
    {
        return $this->runInline('tail --bytes=2000000 ' . $task->outputFile(), 10)->getOutput();
    }

    /**
     * Dispatch related jobs
     *
     * @param Task $task
     */
    protected function runCallbacks(Task $task): void
    {
        $task->callbacks()->each(function ($callback) use ($task) {
            if (!is_object($callback)) {
                $callback = app($callback);
            }

            $callback->handle($task);

            $this->handledCallbacks[] = get_class($callback);
        });
    }

    /**
     * @return array
     */
    public function getHandledCallbacks(): array
    {
        return $this->handledCallbacks;
    }
}
