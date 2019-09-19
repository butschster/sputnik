<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class CallbackLog extends Model
{
    use UsesUuid;

    /**
     * {@inheritdoc}
     */
    protected $table = 'callback_logs';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'data' => 'array'
    ];
}
