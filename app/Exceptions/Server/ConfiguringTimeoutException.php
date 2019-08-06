<?php

namespace App\Exceptions\Server;

use App\Models\Server;
use Exception;

class ConfiguringTimeoutException extends Exception
{
    /**
     * Create a new exception for a configurable server.
     *
     * @param  Server $server
     * @return static
     */
    public static function for(Server $server)
    {
        return new static("Timed out while configurable [{$server->name}] server");
    }
}
