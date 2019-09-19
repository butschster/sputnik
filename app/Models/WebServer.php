<?php

namespace App\Models;

use App\Models\Server\Daemon;
use App\Models\Server\Database;
use App\Models\Server\Site;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebServer extends Server
{

    /**
     * Get the sites that belong to the server.
     * @return HasMany
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class, 'server_id')->latest();
    }

    /**
     * Get the daemons that belong to the server.
     * @return HasMany
     */
    public function daemons(): HasMany
    {
        return $this->hasMany(Daemon::class, 'server_id')->latest();
    }

    /**
     * Get the databases that belong to the server.
     * @return HasMany
     */
    public function databases(): HasMany
    {
        return $this->hasMany(Database::class, 'server_id')->latest();
    }
}
