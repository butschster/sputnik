<?php

namespace App\Console\Commands\Server;

use App\Events\Server\Configured;
use App\Models\Concerns\Prunable;
use App\Models\Server;
use Illuminate\Console\Command;

class InstallModules extends Command
{
    use Prunable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servers:install-modules {server}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $server = Server::findOrFail($this->argument('server'));

        event(new Configured($server));
    }
}
