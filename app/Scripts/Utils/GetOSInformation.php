<?php

namespace App\Scripts\Utils;

use App\Models\Server;
use Domain\SSH\Script;

class GetOSInformation extends Script
{
    /**
     * The displayable name of the script.
     *
     * @var string
     */
    public $name = 'Getting OS information';

    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('scripts.utils.get_os_information', [
            'server' => $this->server
        ])->render();
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function getTimeout(): int
    {
        return 5;
    }
}

