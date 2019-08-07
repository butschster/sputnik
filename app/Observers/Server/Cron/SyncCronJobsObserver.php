<?php

namespace App\Observers\Server\Cron;

use App\Events\Server\CronJob\Created;
use App\Events\Server\CronJob\Deleted;
use App\Models\Server\CronJob;
use App\Services\Server\CronService;

class SyncCronJobsObserver
{
    /**
     * @var CronService
     */
    protected $service;

    /**
     * @param CronService $service
     */
    public function __construct(CronService $service)
    {
        $this->service = $service;
    }

    /**
     * @param CronJob $job
     */
    public function created(CronJob $job): void
    {
        $this->service->schedule($job);
    }

    /**
     * @param CronJob $job
     */
    public function deleted(CronJob $job): void
    {
        $this->service->delete($job);
    }
}
