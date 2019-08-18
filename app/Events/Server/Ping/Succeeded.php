<?php

namespace App\Events\Server\Ping;

use App\Models\Server;

class Succeeded
{
    /**
     * @var Server
     */
    public $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }
}