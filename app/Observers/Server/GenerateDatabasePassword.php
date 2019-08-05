<?php

namespace App\Observers\Server;

use App\Models\Server;
use Illuminate\Support\Str;

class GenerateDatabasePassword
{
    /**
     * @param Server $server
     */
    public function creating(Server $server)
    {
        $server->database_password = Str::random();
    }
}
