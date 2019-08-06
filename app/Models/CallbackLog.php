<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class CallbackLog extends Model
{
    use UsesUuid;

    /**
     * @var string
     */
    protected $table = 'callback_logs';

    /**
     * @var string
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];
}
