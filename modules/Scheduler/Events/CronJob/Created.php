<?php

namespace Module\Scheduler\Events\CronJob;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\Scheduler\Models\CronJob;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var CronJob
     */
    public $job;

    /**
     * @param CronJob $job
     */
    public function __construct(CronJob $job)
    {
        $this->job = $job;
    }
}