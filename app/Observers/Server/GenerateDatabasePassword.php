<?php

namespace App\Observers\Server;

use App\Models\Server;
use Illuminate\Support\Str;

class GenerateDatabasePassword
{
    /**
     * @param Server $server
     */
    public function creating(Server $server): void
    {
        $meta = $server->meta;

        $meta['database_password'] = Str::random();

        $server->meta = $meta;
    }
}
