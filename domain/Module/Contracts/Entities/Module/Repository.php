<?php

namespace Domain\Module\Contracts\Entities\Module;

use App\Models\Server;
use Domain\Module\Exceptions\ModuleNotFoundException;

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
     * @throws ModuleNotFoundException
     */
    public function runAction(string $module, string $action, Server $server, array $data = []): Server\Action;
}