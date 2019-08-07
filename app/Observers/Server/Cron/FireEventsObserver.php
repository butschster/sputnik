<?php

namespace App\Observers\Server\Cron;

use App\Events\Server\CronJob\Created;
use App\Events\Server\CronJob\Deleted;
use App\Models\Server\CronJob;

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
