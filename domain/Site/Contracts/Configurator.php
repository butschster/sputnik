<?php

namespace Domain\Site\Contracts;

use App\Models\Server;
use Domain\Site\Contracts\Entities\Processor;
use Domain\Site\Contracts\Entities\WebServer;
use Illuminate\Support\Collection;

interface Configurator
{
    /**
     * Register a new web server
     *
     * @param WebServer $webServer
     */
    public function registerWebServer(WebServer $webServer): void;

    /**
     * Register a new processor
     *
     * @param Processor $processor
     */
    public function registerProcessor(Processor $processor): void;

    /**
     * Get web servers options for select
     *
     * @param Server $server
     * @return Collection
     */
    public function getWebServersOptionsForServer(Server $server): Collection;

    /**
     * Get processors options for select
     *
     * @param Server $server
     * @return Collection
     */
    public function getProcessorsOptionsForServer(Server $server): Collection;
}