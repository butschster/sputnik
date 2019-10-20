<?php

namespace App\Contracts\Server\Modules;

use App\Models\Server;

interface Repository
{
    /**
     * Run action on specific server
     *
     * @param string $module
     * @param string $action
     * @param Server $server
     * @param array $data
     *
     * @return Server\Action
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function runAction(string $module, string $action, Server $server, array $data = []): Server\Action;
}