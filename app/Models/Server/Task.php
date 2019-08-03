<?php

namespace App\Models\Server;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use UsesUuid;

    const STATUS_PENDING = 'pending';
    const STATUS_RUNNING = 'running';
    const STATUS_FINISHED = 'finished';

    /**
     * @var string
     */
    protected $table = 'server_tasks';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'options',
        'output',
        'script',
    ];
}
