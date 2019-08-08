<?php

namespace App\Scripts\Server;

use App\Models\Server;
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
        $configurator = server_configurator($this->server);

        return view('scripts.server.configure', [
            'script' => $this,
            'users' => $configurator->systemUsers(),
            'server' => $this->server,
            'configurator' => $configurator
        ])->render();
    }
}
