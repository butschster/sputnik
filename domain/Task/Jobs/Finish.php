<?php

namespace Domain\Task\Jobs;

use App\Models\Server\Task;
use Domain\Task\Services\FinishService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Finish implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The task instance.
     *
     * @var Task
     */
    public $task;

    /**
     * The task script's exit code.
     *
     * @var int
     */
    public $exitCode;

    /**
     * @param Task $task
     * @param int $exitCode
     * @return void
     */
    public function __construct(Task $task, int $exitCode = 0)
    {
        $this->task = $task;
        $this->exitCode = $exitCode;
    }

    /**
     * Execute the job.
     *
     * @param FinishService $service
     * @return void
     */
    public function handle(FinishService $service): void
    {
        $service->finish($this->task, $this->exitCode);
    }
}
