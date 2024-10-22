<?php

namespace Domain\Server\Jobs;

use App\Models\Server;
use Bestnetwork\Telnet\TelnetClient;
use Bestnetwork\Telnet\TelnetException;
use Domain\Alert\Builder;
use Domain\Server\Events\Ping\Checked;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Telnet implements ShouldQueue
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
     * @throws \Exception
     */
    public function handle()
    {
        $client = new TelnetClient($this->server->ip, $this->server->ssh_port);

        try {
            $client->connect();
            $status = true;
        } catch (TelnetException $e) {
            $status = false;
        }

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
        Builder::for($this->server, $exception)
            ->setType('server.telnet.failed')
            ->store();
    }
}