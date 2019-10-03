<?php

namespace Module\Scheduler\Listeners;

use App\Events\Server\Configured;
use Module\Scheduler\CronService;

class ScheduleSystemJobs
{
    /**
     * @var CronService
     */
    protected $service;

    /**
     * @var array
     */
    protected $jobs = [
        [
            'name' => 'Clean system',
            'command' => 'apt-get autoremove && apt-get autoclean',
            'user' => 'root',
            'cron' => '@weekly',
        ],
    ];

    /**
     * @param CronService $service
     */
    public function __construct(CronService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Configured $event
     */
    public function handle(Configured $event): void
    {
        foreach ($this->jobs as $job) {
            $event->server->cronJobs()->create($job);
        }
    }
}