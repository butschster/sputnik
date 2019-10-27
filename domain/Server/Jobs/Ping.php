<?php

namespace Domain\Server\Jobs;

use App\Models\Server;
use Domain\Server\Events\Ping\Checked;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Ping implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

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

    /**
     * @throws Exception
     */
    public function handle()
    {
        $ping = new \JJG\Ping($this->server->ip, 128, 1);

        $status = (bool)$ping->ping();

        $this->server->pings()->create([
            'success' => $status,
        ]);

        event(new Checked($this->server, $status));
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->server->alerts()->create([
            'type' => 'server.ping.failed',
            'exception' => (string) $exception,
        ]);
    }
}