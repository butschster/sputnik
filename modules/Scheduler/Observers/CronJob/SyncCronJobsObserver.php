<?php

namespace Module\Scheduler\Observers\CronJob;

use Module\Scheduler\CronService;
use Module\Scheduler\Models\CronJob;

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
