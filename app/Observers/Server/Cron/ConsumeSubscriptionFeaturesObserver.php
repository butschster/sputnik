<?php

namespace App\Observers\Server\Cron;

use App\Models\Server\CronJob;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param CronJob $cronJob
     */
    public function created(CronJob $cronJob): void
    {
        $cronJob->server->user->useFeature('server.cron_job.create');
    }

    /**
     * @param CronJob $cronJob
     */
    public function deleted(CronJob $cronJob): void
    {
        $cronJob->server->user->returnFeature('server.cron_job.create');
    }
}
