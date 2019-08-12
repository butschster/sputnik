<?php

namespace App\Contracts\Server;

use App\Scripts\Tools\DatabaseConfigurator;
use App\Scripts\Tools\PHPConfigurator;
use App\Scripts\Tools\WebServerConfigurator;

interface ServerConfigurationManager
{
    /**
     * Get system users
     *
     * @return array
     */
    public function systemUsers(): array;

    /**
     * Get PHP configurator
     *
     * @return PHPConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    public function php(): PHPConfigurator;

    /**
     * Get Web server configurator
     *
     * @return WebServerConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    public function webserver(): WebServerConfigurator;

    /**
     * Get database configurator
     *
     * @return DatabaseConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    public function database(): DatabaseConfigurator;
}
