<?php

namespace App\Models\Server;

use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use UsesUuid, HasTask;

    /**
     * @var string
     */
    protected $table = 'server_sites';

    /**
     * @var array
     */
    protected $casts = [
        'aliases' => 'array',
    ];
}
