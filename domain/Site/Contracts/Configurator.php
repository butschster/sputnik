<?php

namespace Domain\Site\Contracts;

use App\Models\Server;
use Domain\Site\Contracts\Entities\Processor;
use Domain\Site\Contracts\Entities\WebServer;
use Domain\Site\Exceptions\ProcessorConfiguratorNotFound;
use Domain\Site\Exceptions\WebServerConfiguratorNotFound;
use Domain\Site\ValueObjects\Site;
use Domain\SSH\Script;
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

    /**
     * Create configuration for new site
     *
     * @param string $webServer
     * @param string|null $processor
     * @param Site $site
     *
     * @return Script
     */
    public function createConfiguration(string $webServer, ?string $processor = null, Site $site): Script;

    /**
     * Delete configuration for the site
     *
     * @param string $webServer
     * @param string|null $processor
     * @param Site $site
     *
     * @return Script
     */
    public function deleteConfiguration(string $webServer, ?string $processor = null, Site $site): Script;

    /**
     * Get web server
     *
     * @param string $webServer
     *
     * @return WebServer
     * @throws WebServerConfiguratorNotFound
     */
    public function getWebServer(string $webServer): WebServer;

    /**
     * Get processor
     *
     * @param string $processor
     * @return Processor
     * @throws ProcessorConfiguratorNotFound
     */
    public function getProcessor(string $processor): Processor;
}