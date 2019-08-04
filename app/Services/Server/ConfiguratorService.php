<?php

namespace App\Services\Server;

use App\Callbacks\MarkAsProvisioned;
use App\Models\Server;
use App\Scripts\Server\Configure;
use App\Scripts\Utils\GetAptLockStatus;
use App\Scripts\Utils\GetCurrentDirectory;
use App\Services\Server\Callbacks\MarkAsConfigured;
use App\Services\Task\Factory;
use App\Services\Task\RunnerService;

class ConfiguratorService
{
    use Runnable;

    /**
     * @var Factory
     */
    protected $tasksFactory;

    /**
     * @var RunnerService
     */
    protected $runnerService;

    /**
     * @param Factory $tasksFactory
     * @param RunnerService $runnerService
     */
    public function __construct(Factory $tasksFactory, RunnerService $runnerService)
    {
        $this->tasksFactory = $tasksFactory;
        $this->runnerService = $runnerService;
    }

    /**
     * @param Server $server
     * @return Server\Task
     */
    public function configure(Server $server)
    {
       $this->server = $server;

       if (! $this->server->isConfiguring()) {
            $this->server->markAsConfiguring();

            $script = new Configure($server);

            return $this->runInBackground($script, [
                'then' => [
                    MarkAsConfigured::class,
                ],
            ]);
       }
    }

    /**
     * Determine if the server is ready for provisioning.
     *
     * @param Server $server
     * @return bool
     */
    public function isServerReadyForConfigure(Server $server): bool
    {
        $this->server = $server;

        $canAccess = $this->run(new GetCurrentDirectory())->output == '/root';

        if ($canAccess) {
            $apt = $this->run(new GetAptLockStatus());
        } else {
            return false;
        }

        return $apt->isSuccessful() && $apt->output === '';
    }
}
