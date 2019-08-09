<?php

namespace App\Jobs\Server;

use App\Exceptions\Server\ConfiguringTimeoutException;
use App\Exceptions\Server\ServerFailedException;
use App\Models\Server;
use App\Scripts\Utils\GetOSInformation;
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
    public $tries = 41; // 20 Total Minutes...

    /**
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @param ConfiguratorService $service
     * @throws \Throwable
     */
    public function handle(ConfiguratorService $service)
    {
        if (!$this->server->systemInformation()) {
            dispatch(new RunScript(
                $this->server, new GetOSInformation($this->server)
            ));

            return $this->release(now()->addSeconds(10));
        }

        if ($this->server->isFailed()) {
            return $this->fail(
                new ServerFailedException('Server failed . [' . $this->server->id . ']')
            );
        }

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
            return $this->fail(ConfiguringTimeoutException::for($this->server));
        }

        $this->release(now()->addSeconds(30));
    }

    /**
     * Perform any tasks after the server is provisioned.
     *
     * @return void
     */
    protected function configured(): void
    {

    }

}
