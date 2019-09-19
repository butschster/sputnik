<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use App\Services\Server\CronService;

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
            'name' => 'Update composer',
            'command' => '/usr/local/bin/composer self-update',
            'user' => 'root',
            'cron' => '@daily',
        ],
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
        $jobs = [];
        switch ($event->server->type) {
            case 'webserver':
                $jobs = $this->jobs;
                break;
        }

        foreach ($jobs as $job) {
            $event->server->cronJobs()->create($job);
        }
    }
}
