<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use App\Events;

class Alert extends Model
{
    use UsesUuid, HasServer;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'exception',
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => Events\Server\Alert\Created::class,
    ];

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->exception;
    }
}
