<?php

namespace App\Models\Server\OpenVPN;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use UsesUuid, HasTask, HasServer;

    /**
     * {@inheritdoc}
     */
    protected $table = 'openvpn_clients';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];
}