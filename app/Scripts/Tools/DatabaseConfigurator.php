<?php

namespace App\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Models\Server\Database;

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
     * @param Database $database
     *
     * @return string
     * @throws \Throwable
     */
    public function createDatabase(Database $database): string
    {
        return $this->render('tools.database.' . $this->type() . '.database.create', [
            'database' => $database
        ]);
    }

    /**
     * @param Database $database
     *
     * @return string
     * @throws \Throwable
     */
    public function dropDatabase(Database $database): string
    {
        return $this->render('tools.database.' . $this->type() . '.database.drop', [
            'database' => $database
        ]);
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
