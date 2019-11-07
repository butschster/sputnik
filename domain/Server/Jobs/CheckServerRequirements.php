<?php

namespace Domain\Server\Jobs;

use App\Models\Server;
use Domain\Alert\Builder;
use Domain\Server\Exceptions\ConfigurationException;
use Domain\Server\Exceptions\ServerFailedException;
use Domain\Server\Services\ConfiguratorService;
use Domain\SSH\Jobs\RunScript;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckServerRequirements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 10;

    /**
     * @var Server
     */
    protected $server;

    /**
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
        try {
            if (!$service->isServerReadyForConfigure($this->server)) {
                throw  new ConfigurationException('Server failed . [' . $this->server->id . ']');
            }
        } catch (\Exception $e) {
            return $this->fail($e);
        }

        $service->configure($this->server);
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->server->markAsFailed();

        Builder::for($this->server, $exception)
            ->setType('server.configure.failed')
            ->store();
    }

}