<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use UsesUuid, HasServer, HasTask;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_records';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}