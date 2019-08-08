<?php

namespace App\Scripts;

use App\Scripts\Contracts\ServerConfiguration;
use App\Scripts\Tools\DatabaseConfigurator;
use App\Scripts\Tools\PHPConfigurator;
use App\Scripts\Tools\WebServerConfigurator;

class ServerConfigurationManager
{
    /**
     * @var ServerConfiguration
     */
    protected $configuration;

    /**
     * @param ServerConfiguration $configuration
     */
    public function __construct(ServerConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Get system users
     *
     * @return array
     */
    public function systemUsers(): array
    {
        return $this->configuration->systemUsers();
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
            $this->configuration
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
            $this->configuration
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
            $this->configuration
        );
    }
}
