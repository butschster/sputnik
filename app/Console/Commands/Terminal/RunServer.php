<?php

namespace App\Console\Commands\Terminal;

use App\Utils\SSH\Terminal\Server;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use SplObjectStorage;

class RunServer extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'terminal:server';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Run websocket server for terminal clients';

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(new Server(
                    new SplObjectStorage(), $this->getOutput()
                ))
            ),
            $port = config('terminal.server.port')
        );

        $this->info(sprintf('Terminal server started on port [%d]', $port));

        $server->run();
    }
}
