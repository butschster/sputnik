<?php

namespace App\Models\Concerns;

use App\Models\Server;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @param Builder $builder
     * @param Server $server
     * @return Builder
     */
    public function scopeForServer(Builder $builder, Server $server)
    {
        return $builder->where('server_id', $server->id);
    }
}
