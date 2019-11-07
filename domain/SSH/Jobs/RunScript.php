<?php

namespace Domain\SSH\Jobs;

use Domain\Alert\Builder;
use Domain\Task\Jobs\Run;
use App\Models\Server;
use Domain\Task\Contracts\Task;
use Domain\Task\Factory;
use Domain\SSH\Contracts\Script;
use Exception;
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
     *
     * @return Task
     */
    public function handle(Factory $taskFactory): Task
    {
        $task = $taskFactory->createFromScript(
            $this->server, $this->script
        );

        dispatch(new Run($task));

        return $task;
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
            ->setType('server.task.failed')
            ->setMeta([
                'script' => $this->script->getName()
            ])
            ->store();
    }
}
