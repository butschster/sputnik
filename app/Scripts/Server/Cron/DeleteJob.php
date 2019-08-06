<?php

namespace App\Scripts\Server\Cron;

use App\Models\Server\CronJob;
use App\Utils\SSH\Script;

class DeleteJob extends Script
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
        return "Delete scheduled Job";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('scripts.server.cron.delete_job', [
            'script' => $this,
            'job' => $this->job,
        ])->render();
    }
}
