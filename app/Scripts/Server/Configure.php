<?php

namespace App\Scripts\Server;

use App\Models\Server;
use App\Services\Server\FirewallService;
use App\Utils\SSH\Script;

class Configure extends Script
{
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
     * Get the name of the script.
     *
     * @return string
     */
    public function getName(): string
    {
        return "Configuring server [{$this->server->name}]";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        $configuration = $this->server->toConfiguration();
        $users = $configuration->systemUsers();

        return view('scripts.server.configuration.base', [
            'script' => $this,
            'server' => $this->server,
            'configuration' => $this->server->toConfiguration(),
            'users' => $users
        ])->render();
    }
}
