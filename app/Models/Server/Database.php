<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Database extends Model
{
    use UsesUuid, HasServer, HasTask;

    const DEFAULT_COLLATION = 'utf8_unicode_ci';
    const DEFAULT_CHARACTER_SET = 'utf8';

    /**
     * @var string
     */
    protected $table = 'server_databases';

    /**
     * @var array
     */
    protected $guarded = [];
}
