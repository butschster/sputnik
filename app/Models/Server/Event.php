<?php

namespace App\Models\Server;

use App\Models\Concerns\UsesUuid;
use App\Utils\SSH\ValueObjects\PublicKey;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use UsesUuid;

    /**
     * @var string
     */
    protected $table = 'server_events';

    /**
     * @var array
     */
    protected $guarded = [];
}
