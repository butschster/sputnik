<?php

namespace App\Listeners\Server;

use App\Events\Server\Site\Deployment\Finished;
use App\Services\Server\SupervisorService;

class RestartSupervisor
{
    /**
     * @var SupervisorService
     */
    protected $service;

    /**
     * @param SupervisorService $service
     */
    public function __construct(SupervisorService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Finished $finished
     */
    public function handle(Finished $finished)
    {
        $server = $finished->deployment->site->server;

        $server->daemons->each(function ($daemon) {

            $this->service->restart($daemon);

        });
    }
}
