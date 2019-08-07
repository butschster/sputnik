<?php

namespace App\Jobs\Server;

use App\Jobs\Task\Run;
use App\Models\Server;
use App\Services\Task\Factory;
use App\Utils\SSH\Contracts\Script;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunScript
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var Script
     */
    protected $script;

    /**
     * @param Server $server
     * @param Script $script
     */
    public function __construct(Server $server, Script $script)
    {
        $this->server = $server;
        $this->script = $script;
    }

    /**
     * @param Factory $taskFactory
     */
    public function handle(Factory $taskFactory): void
    {
        $task = $taskFactory->createFromScript(
            $this->server, $this->script
        );

        dispatch(new Run($task));
    }
}
