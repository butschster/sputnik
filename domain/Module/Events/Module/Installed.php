<?php

namespace Domain\Module\Events\Module;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Installed
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    public $server;

    /**
     * @var string
     */
    public $module;

    /**
     * @param Server $server
     * @param string $module
     */
    public function __construct(Server $server, string $module)
    {
        $this->server = $server;
        $this->module = $module;
    }
}