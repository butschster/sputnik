<?php

namespace App\Models\Server;

use App\Models\Concerns\Prunable;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use UsesUuid, Prunable;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_events';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}
