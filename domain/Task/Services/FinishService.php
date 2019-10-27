<?php

namespace Domain\Task\Services;

use App\Events\Task\CallbacksHandled;
use Domain\Task\Contracts\Task;
use Domain\SSH\Contracts\ProcessExecutor;

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
    public function finish(Task $task, int $exitCode = 0): void
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
     * @param int $bytes
     * @return string
     */
    protected function retrieveOutput(Task $task, int $bytes = 2000000): string
    {
        return $this->runInline(
            sprintf('tail --bytes=%d %s', $bytes, $task->outputFile()),
            10
        )->getOutput();
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

            logger()->debug('Task callback', [
                'task' => $task,
                'callback' => get_class($callback)
            ]);

            $callback->handle($task);

            $this->handledCallbacks[] = get_class($callback);
        });

        event(
            new CallbacksHandled($task, $this->handledCallbacks)
        );
    }

    /**
     * @return array
     */
    public function getHandledCallbacks(): array
    {
        return $this->handledCallbacks;
    }
}
