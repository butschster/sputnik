<?php

namespace App\Console\Commands\Server;

use App\Jobs\Server\Ping;
use App\Models\Concerns\Prunable;
use App\Models\Server;
use Illuminate\Console\Command;

class PingServer extends Command
{
    use Prunable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:ping';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Server::withMonitoring()->configured()->get()->each(function(Server $server) {
            dispatch(new Ping($server));
        });
    }
}
