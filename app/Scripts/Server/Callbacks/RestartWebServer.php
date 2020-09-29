<?php

namespace App\Scripts\Server\Callbacks;

use App\Models\Server\Deployment;
use App\Models\Server\Site;
use Domain\Site\Contracts\Configurator;
use Domain\Task\Contracts\Script\Callback;
use Domain\SSH\Jobs\RunScript;
use App\Models\Server\Task;
use App\Scripts\Server\CustomScript;

class RestartWebServer implements Callback
{
    /**
     * @var Configurator
     */
    protected $configurator;

    /**
     * @param Configurator $configurator
     */
    public function __construct(Configurator $configurator)
    {
        $this->configurator = $configurator;
    }

    /**
     * @param Task $task
     * @throws \Domain\Site\Exceptions\ProcessorConfiguratorNotFound
     * @throws \Domain\Site\Exceptions\WebServerConfiguratorNotFound
     */
    public function handle(Task $task): void
    {
        if (!$task->owner instanceof Deployment) {
            return;
        }

        if (!$task->owner->owner instanceof Site) {
            return;
        }

        $this->restartWebServer($task);
        $this->restartProcessor($task);
    }

    /**
     * @param Task $task
     * @throws \Domain\Site\Exceptions\WebServerConfiguratorNotFound
     */
    protected function restartWebServer(Task $task): void
    {
        $site = $task->owner->owner;
        $webServer = $site->webServer->name;
        $script = $this->configurator->getWebServer($webServer)->restartScript();

        dispatch(
            new RunScript(
                $task->server,
                new CustomScript("Restart Web Server {$webServer}", $script)
            )
        );
    }

    /**
     * @param Task $task
     * @throws \Domain\Site\Exceptions\ProcessorConfiguratorNotFound
     */
    protected function restartProcessor(Task $task): void
    {
        $site = $task->owner->owner;
        $processor = $site->processor->name;
        $script = $this->configurator->getProcessor($processor)->restartScript();

        if (empty($script)) {
            return;
        }

        dispatch(
            new RunScript(
                $task->server,
                new CustomScript("Restart processor {$processor}", $script)
            )
        );
    }
}