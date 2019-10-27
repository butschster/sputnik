<?php

namespace Domain\Module\Events\Module;

use App\Models\Server;

class Installed
{
    /**
     * @var Server
     */
    public $server;

    /**
     * @var string
     */
    public $module;

    /**
     * @param Server $server
     * @param string $module
     */
    public function __construct(Server $server, string $module)
    {
        $this->server = $server;
        $this->module = $module;
    }
}