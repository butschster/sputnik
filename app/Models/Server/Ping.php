<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use Illuminate\Database\Eloquent\Model;

class Ping extends Model
{
    use HasServer;

    /**
     * {@inheritdoc}
     */
    const UPDATED_AT = null;

    /**
     * {@inheritdoc}
     */
    public $incrementing = false;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_pings';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}