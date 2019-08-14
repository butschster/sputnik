<?php

namespace App\Scripts\Server\Supervisor;

use App\Models\Server;
use App\Utils\SSH\Script;

class Restart extends Script
{
    /**
     * @var Server\Daemon
     */
    protected $daemon;

    /**
     * @param Server\Daemon $daemon
     */
    public function __construct(Server\Daemon $daemon)
    {
        $this->daemon = $daemon;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return view('scripts.server.supervisor.restart', [
            'daemon' => $this->daemon
        ]);
    }
}
