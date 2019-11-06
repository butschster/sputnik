<?php

namespace Domain\Task\Services;

use App\Events\Task\CallbacksHandled;
use Domain\SSH\Exceptions\SSHConnectionRefusedException;
use Domain\SSH\Exceptions\SSHPermissionDeniedException;
use Domain\Task\Contracts\Task;
use Domain\SSH\Contracts\ProcessExecutor;
use Illuminate\Support\Str;

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
     * @throws \Exception
     */
    public function finish(Task $task, int $exitCode = 0): void
    {
        $this->task = $task;

        $task->saveOutput(
            $output = $this->retrieveOutput($task)
        );

        try {
            $this->checkOutputForErrors($output);
        } catch (\Exception $e) {
            $task->markAsTimedOut($exitCode);
            throw $e;
        }

        if ($task->isRunning()) {
            $task->markAsFinished($exitCode);
        }

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
                'callback' => get_class($callback),
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

    /**
     * @param string $output
     */
    protected function checkOutputForErrors(string $output): void
    {
        if (Str::contains($output, 'Permission denied (publickey)')) {
            throw new SSHPermissionDeniedException($output);
        }

        if (Str::contains($output, 'Connection refused')) {
            throw new SSHConnectionRefusedException($output);
        }
    }
}
