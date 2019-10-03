<?php

namespace Module\Scheduler\Observers\CronJob;

use Module\Scheduler\Models\CronJob;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param CronJob $cronJob
     */
    public function created(CronJob $cronJob): void
    {
        $cronJob->server->team->useFeature('server.cron_job.create');
    }

    /**
     * @param CronJob $cronJob
     */
    public function deleted(CronJob $cronJob): void
    {
        $cronJob->server->team->returnFeature('server.cron_job.create');
    }
}
