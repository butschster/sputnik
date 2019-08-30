<?php

namespace App\Jobs\Task;

use App\Services\Task\Contracts\ExecutorService;
use App\Services\Task\Contracts\Task;
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
}
