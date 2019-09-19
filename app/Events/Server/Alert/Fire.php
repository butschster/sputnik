<?php

namespace App\Events\Server\Alert;

use App\Models\Server;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Fire
{
    use Dispatchable, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * @var Server
     */
    public $server;

    /**
     * @param Server $server
     * @param array $data
     */
    public function __construct(Server $server, array $data)
    {
        $this->data = $data;
        $this->server = $server;
    }
}
