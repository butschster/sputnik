<?php

namespace App\Contracts\Server\Modules;

use App\Models\Server;

interface Repository
{
    /**
     * Install module on specific server
     *
     * @param string $module
     * @param Server $server
     * @param array $data
     *
     * @return Server\Module
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function install(string $module, Server $server, array $data = []): Server\Module;

    /**
     * Uninstall module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function uninstall(Server\Module $module): void;

    /**
     * Restart module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function restart(Server\Module $module): void;

    /**
     * Start module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function start(Server\Module $module): void;

    /**
     * Stop module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function stop(Server\Module $module): void;
}