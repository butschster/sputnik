<?php

namespace App\Services\Server;

use App\Models\Server\CronJob;
use App\Scripts\Server\Cron\DeleteJob;
use App\Scripts\Server\Cron\ScheduleJob;
use App\Services\Task\Contracts\Task;
use Carbon\Carbon;
use Cron\CronExpression;

class CronService
{
    use Runnable;

    /**
     * Convert named expression to
     *
     * @param string $expression
     *
     * @return string
     */
    public function parseExpression(string $expression): string
    {
        return CronExpression::factory($expression)->getExpression();
    }

    /**
     * Get a next run date relative to the current date or a specific date
     *
     * @param string $expression
     *
     * @return Carbon
     */
    public function nextRunDate(string $expression): Carbon
    {
        return \Illuminate\Support\Carbon::instance(
            CronExpression::factory($expression)->getNextRunDate()
        );
    }

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
     * @return Task
     */
    public function schedule(CronJob $job): Task
    {
        $this->setServer($job->server);
        $this->setOwner($job);

        return $this->runJob(
            new ScheduleJob($job)
        );
    }

    /**
     * Delete scheduled job
     *
     * @param CronJob $job
     * @return Task
     */
    public function delete(CronJob $job): Task
    {
        $this->setServer($job->server);
        $this->setOwner($job);

        return $this->runJob(
            new DeleteJob($job)
        );
    }
}
