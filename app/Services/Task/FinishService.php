<?php

namespace App\Services\Task;

use App\Services\Task\Contracts\Task;

class FinishService
{
    /**
     * Mark the task as finished and gather its output.
     *
     * @param Task $task
     * @param int $exitCode
     */
    public function finish(Task $task, int $exitCode = 0)
    {
        $task->markAsFinished($exitCode, $this->retrieveOutput());

        $options = $task->options();

        foreach ($options['then'] ?? [] as $callback) {
            is_object($callback)
                ? $callback->handle($task)
                : app($callback)->handle($task);
        }
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
}
