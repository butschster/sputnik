<?php

namespace App\Models\Concerns;

use App\Models\Server;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasServer
{
    /**
     * Link to the server
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
}
