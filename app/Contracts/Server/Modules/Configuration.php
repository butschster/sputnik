<?php

namespace App\Contracts\Server\Modules;

use App\Models\Server;

interface Configuration
{
    /**
     * Install module
     *
     * @param Server $server
     * @param array $data
     *
     * @return array
     */
    public function install(Server $server, array $data): array;

    /**
     * Uninstall module
     *
     * @param Server $server
     */
    public function uninstall(Server $server): void;

    /**
     * Restart module
     *
     * @param Server $server
     */
    public function restart(Server $server): void;

    /**
     * Stop module
     *
     * @param Server $server
     */
    public function stop(Server $server): void;

    /**
     * Start module
     *
     * @param Server $server
     */
    public function start(Server $server): void;

    /**
     * @param Server $server
     *
     * @return bool
     */
    public function checkRequirements(Server $server): bool;
}