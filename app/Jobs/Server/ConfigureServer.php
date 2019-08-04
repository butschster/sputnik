<?php

namespace App\Jobs\Server;

use App\Events\Server\Configured;
use App\Exceptions\Server\ConfiguringTimeout;
use App\Models\Server;
use App\Services\Server\ConfiguratorService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConfigureServer implements ShouldQueue
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
    public $tries = 40; // 20 Total Minutes...

    /**
     * Create a new job instance.
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Execute the job.
     *
     * @param ConfiguratorService $service
     * @return void
     */
    public function handle(ConfiguratorService $service)
    {
        if ($this->server->isConfigured()) {
            try {
                $this->configured();
            } catch (\Exception $e) {
                report($e);
            }
            return $this->delete();
        } elseif ($this->server->isConfiguring()) {
            return $this->release(now()->addSeconds(30));
        } elseif ($service->isServerReadyForConfigure($this->server)) {
            $service->configure($this->server);
        } elseif ($this->server->olderThan(now()->addDay(), 'configuring_job_dispatched_at')) {
            return $this->fail(ConfiguringTimeout::for($this->server));
        }

        $this->release(now()->addSeconds(30));
    }

    /**
     * Perform any tasks after the server is provisioned.
     *
     * @return void
     */
    protected function configured()
    {
        event(new Configured($this->server));
    }

}
