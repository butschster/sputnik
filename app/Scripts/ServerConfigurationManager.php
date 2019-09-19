<?php

namespace App\Scripts;

use App\Contracts\Server\ServerConfigurationManager as ServerConfigurationManagerContract;
use App\Models\Server;
use App\Scripts\Tools\DatabaseConfigurator;
use App\Scripts\Tools\PHPConfigurator;
use App\Scripts\Tools\WebServerConfigurator;

class ServerConfigurationManager implements ServerConfigurationManagerContract
{
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
     * Get system users
     *
     * @return array
     */
    public function systemUsers(): array
    {
        return $this->server->toConfiguration()->systemUsers();
    }

    /**
     * Get PHP configurator
     *
     * @return PHPConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    public function php(): PHPConfigurator
    {
        return new PHPConfigurator(
            $this->server
        );
    }

    /**
     * Get Web server configurator
     *
     * @return WebServerConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    public function webserver(): WebServerConfigurator
    {
        return new WebServerConfigurator(
            $this->server
        );
    }

    /**
     * Get database configurator
     *
     * @return DatabaseConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    public function database(): DatabaseConfigurator
    {
        return new DatabaseConfigurator(
            $this->server
        );
    }
}
