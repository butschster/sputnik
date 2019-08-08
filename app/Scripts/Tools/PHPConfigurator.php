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
        return $this->configuration->phpVersion();
    }

    /**
     * Get current version of PHP
     *
     * @return string
     */
    public function humanReadableVersion(): string
    {
        return implode('.', str_split($this->version()));
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
        return $this->render('tools.php.install');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function uninstall(): string
    {
        return $this->render('tools.php.uninstall');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function restart(): string
    {
        return $this->render('tools.php.restart');
    }

    /**
     * Get command string for install given php modules
     *
     * @param string ...$modules
     * @return string
     */
    public function installModules(string ...$modules)
    {
        $modules = collect($modules)->map(function ($module) {
            return 'php'.$this->humanReadableVersion() . '-' . $module;
        })->implode(' ');

        return 'apt-get install -y --force-yes ' . $modules;
    }

    /**
     * Additional data for render
     *
     * @return array
     */
    protected function data(): array
    {
        return [
            'version' => $this->humanReadableVersion(),
            'modules' => $this->installModules(
                'cli', 'dev', 'pgsql', 'sqlite3', 'gd', 'curl', 'memcached',
                'imap', 'mysql', 'mbstring', 'xml', 'zip', 'bcmath', 'soap',
                'intl', 'readline', 'mongodb'
            )
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
