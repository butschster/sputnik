<?php

namespace App\Events\Server\CronJob;

use App\Models\Server;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Deleted
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
