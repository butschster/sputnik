<?php

namespace Module\Scheduler\Jobs;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Module\Scheduler\ValueObjects\CronJob;

class Schedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var CronJob
     */
    protected $cronJob;

    /**
     * @param Server $server
     * @param CronJob $cronJob
     */
    public function __construct(Server $server, CronJob $cronJob)
    {
        $this->server = $server;
        $this->cronJob = $cronJob;
    }

    public function handle()
    {
        $job = new \Module\Scheduler\Models\CronJob([
            'name' => $this->cronJob->getName(),
            'command' => $this->cronJob->getCommand(),
            'cron' => $this->cronJob->getCronExpression(),
            'user' => $this->cronJob->getUser(),
        ]);

        $job->server()->associate($this->server);
        $job->save();
    }
}
