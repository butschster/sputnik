<?php

namespace Module\Scheduler\Scripts\CronJob;

use App\Utils\SSH\Script;
use Module\Scheduler\Models\CronJob;

class Schedule extends Script
{
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

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function getName(): string
    {
        return "Schedule Job";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('Scheduler::scripts.cron_job.schedule', [
            'job' => $this->job,
        ])->render();
    }
}
