<?php

namespace App\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;

class DatabaseConfigurator extends Configurator
{
    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function availableTypes(): array
    {
        return config('configurations.database', []);
    }

    /**
     * Get root database password
     *
     * @return string
     */
    public function type(): string
    {
        return $this->configuration->databaseType();
    }

    /**
     * Get root database password
     *
     * @return string
     */
    public function password(): string
    {
        return $this->configuration->databasePassword();
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function install(): string
    {
        return $this->render('tools.database.' . $this->type() . '.install');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function uninstall(): string
    {
        return $this->render('tools.database.' . $this->type() . '.uninstall');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function restart(): string
    {
        return $this->render('tools.database.' . $this->type() . '.restart');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function createDatabase(): string
    {
        return $this->render('tools.database.' . $this->type() . '.create_database');
    }

    /**
     * Additional data for render
     *
     * @return array
     */
    protected function data(): array
    {
        return [
            'password' => $this->password(),
            'hosts' => $this->configuration->databaseHosts()
        ];
    }

    protected function checkRequirements(): void
    {
        if (!in_array($this->type(), $this->availableTypes())) {
            throw new ConfigurationNotFoundException(
                "Configuration for given database type [{$this->type()}}] not found"
            );
        }
    }
}
