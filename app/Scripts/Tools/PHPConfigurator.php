<?php

namespace App\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;

class PHPConfigurator extends Configurator
{
    /**
     * Get current version of PHP
     *
     * @return string
     */
    public function version(): string
    {
        return $this->server->php_version;
    }

    /**
     * Get available versions of PHP
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function availableVersions(): array
    {
        return config('configurations.php', []);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function install(): string
    {
        return $this->render('tools.php.' . $this->version() . '.install');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function uninstall(): string
    {
        return $this->render('tools.php.' . $this->version() . '.uninstall');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function restart(): string
    {
        return $this->render('tools.php.' . $this->version() . '.restart');
    }

    /**
     * Additional data for render
     *
     * @return array
     */
    protected function data(): array
    {
        return [
            'version' => $this->version()
        ];
    }

    /**
     * @throws ConfigurationNotFoundException
     */
    protected function checkRequirements(): void
    {
        if (!in_array($this->version(), $this->availableVersions())) {
            throw new ConfigurationNotFoundException(
                "Configuration for given PHP version [{$this->version()}] not found"
            );
        }
    }
}
