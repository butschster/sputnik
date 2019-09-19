<?php

namespace App\Models;

use App\Models\Server\OpenVPN\Client;

class OpenVPNServer extends Server
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'server_id');
    }
}