<?php

namespace App\Services\Server;

use App\Models\Server\CronJob;
use App\Scripts\Server\Cron\DeleteJob;
use App\Scripts\Server\Cron\ScheduleJob;
use Cron\CronExpression;

class CronService
{
    use Runnable;

    /**
     * Validate cron string
     *
     * @param string $expression
     *
     * @return bool
     */
    public function validate(string $expression): bool
    {
        return CronExpression::isValidExpression($expression);
    }

    /**
     * Schedule Job
     *
     * @param CronJob $job
     */
    public function schedule(CronJob $job)
    {
        $this->server = $job->server;

        $this->run(
            new ScheduleJob($job)
        );
    }

    /**
     * Delete scheduled job
     *
     * @param CronJob $job
     */
    public function delete(CronJob $job)
    {
        $this->server = $job->server;

        $this->run(
            new DeleteJob($job)
        );
    }
}
