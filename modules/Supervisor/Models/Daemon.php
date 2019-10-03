<?php

namespace Module\Supervisor\Models;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Daemon extends Model
{
    use UsesUuid, HasServer, HasTask;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_supervisor_daemons';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}
