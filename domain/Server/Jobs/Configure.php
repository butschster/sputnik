<?php

namespace Domain\Server\Jobs;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Configure implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    public $server;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 41; // 20 Total Minutes...

    /**
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;

        $this->chain([
            new CheckServerRequirements($server),
            new GetOSInformation($server),
            new CheckConfigurationProcess($server)
        ]);
    }

    public function handle()
    {

    }
}
