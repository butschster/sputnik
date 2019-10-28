<?php

namespace App\Http\Controllers\API\v1\Server\Site;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Domain\Site\Contracts\Configurator;

class ConfiguratorController extends Controller
{
    /**
     * @param Configurator $configurator
     * @param Server $server
     * @return \Illuminate\Support\Collection
     */
    public function processors(Configurator $configurator, Server $server)
    {
        return $configurator->getProcessorsOptionsForServer($server);
    }

    /**
     * @param Configurator $configurator
     * @param Server $server
     * @return \Illuminate\Support\Collection
     */
    public function webServers(Configurator $configurator, Server $server)
    {
        return $configurator->getWebServersOptionsForServer($server);
    }
}