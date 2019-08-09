<?php

namespace App\Events\Server;

use App\Models\Server;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Failed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Server
     */
    public $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }
}
