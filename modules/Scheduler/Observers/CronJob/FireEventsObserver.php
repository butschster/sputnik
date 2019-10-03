<?php

namespace Module\Scheduler\Observers\CronJob;

use Module\Scheduler\Events\CronJob\Created;
use Module\Scheduler\Events\CronJob\Deleted;
use Module\Scheduler\Models\CronJob;

class FireEventsObserver
{
    /**
     * @param CronJob $job
     */
    public function created(CronJob $job): void
    {
        event(new Created($job));
    }

    /**
     * @param CronJob $job
     */
    public function deleted(CronJob $job): void
    {
        event(new Deleted($job));
    }
}
