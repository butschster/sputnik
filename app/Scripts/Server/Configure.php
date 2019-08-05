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
        return "Configuring Web Server ({$this->server->name})";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('scripts.server.configure', [
            'databasePassword' => $this->server->database_password,
            'script' => $this,
            'server' => $this->server
        ])->render();
    }
}
