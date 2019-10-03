<?php

namespace Module\Supervisor\Scripts\Daemon;

use App\Utils\SSH\Script;
use Module\Supervisor\Models\Daemon;

class Start extends Script
{
    /**
     * @var Daemon
     */
    protected $daemon;

    /**
     * @param Daemon $daemon
     */
    public function __construct(Daemon $daemon)
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
        return view('Supervisor::scripts.daemon.start', [
            'daemon' => $this->daemon
        ]);
    }
}
