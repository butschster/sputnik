<?php

namespace Domain\Task\Jobs;

use Domain\Task\Contracts\ExecutorService;
use Domain\Task\Contracts\Task;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Run implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Task
     */
    public $task;

    /**
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @param ExecutorService $service
     */
    public function handle(ExecutorService $service): void
    {
        set_time_limit($this->task->timeout());

        $service->run(
            $this->task
        );
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->task->server->alerts()->create([
            'type' => 'server.task.failed',
            'exception' => (string) $exception,
            'meta' => [
                'script' => $this->task->name
            ]
        ]);
    }
}
