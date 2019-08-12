<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    use UsesUuid, HasServer, HasTask;

    protected $table = 'server_databases';
}
