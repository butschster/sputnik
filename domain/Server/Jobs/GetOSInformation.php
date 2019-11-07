<?php

namespace Domain\Server\Jobs;

use App\Models\Server;
use Domain\Alert\Builder;
use Domain\Server\Events\Ping\Checked;
use Domain\Server\Exceptions\ConfigurationException;
use Domain\SSH\Jobs\RunScript;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetOSInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 5;

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

    public function handle()
    {
        if ($this->server->isFailed()) {
            return $this->fail(
                new ConfigurationException('Server failed . [' . $this->server->id . ']')
            );
        }

        if (!$this->server->systemInformation()) {
            dispatch(new RunScript(
                $this->server, new \App\Scripts\Utils\GetOSInformation($this->server)
            ));

            $this->release(
                now()->addSeconds(5)
            );
        }
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Builder::for($this->server, $exception)
            ->setType('server.configure.failed')
            ->store();
    }
}