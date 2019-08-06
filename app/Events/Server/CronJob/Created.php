<?php

namespace App\Events\Server\CronJob;

use App\Models\Server;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Server\CronJob
     */
    public $job;

    /**
     * @param Server\CronJob $job
     */
    public function __construct(Server\CronJob $job)
    {
        $this->job = $job;
    }
}
