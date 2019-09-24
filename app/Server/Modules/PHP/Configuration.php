<?php

namespace App\Server\Modules\PHP;

use App\Models\Server;
use App\Server\Modules\Configuration as BaseConfiguration;

class Configuration extends BaseConfiguration
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * Get current version of PHP
     * @return string
     */
    public function version(): string
    {
        return $this->module->version();
    }

    /**
     * Get current version of PHP
     * @return string
     */
    public function humanReadableVersion(): string
    {
        return $this->module->humanReadableVersion();
    }

    /**
     * Install module
     *
     * @param Server $server
     * @param array $data
     *
     * @throws \Throwable
     */
    public function install(Server $server, array $data = []): void
    {
        $data['modules'] = $this->getInstallableModulesFromGivenData($data);
        $data['server_modules'] = $this->prepareModulesListFromGivenData($data);

        $script = $this->render($server, 'php.install', $data);

        $this->runScript(
            $server,
            $script,
            sprintf('Install PHP version %s', $this->humanReadableVersion())
        );
    }

    /**
     * Uninstall module
     *
     * @param Server $server
     * @param array $data
     *
     * @throws \Throwable
     */
    public function uninstall(Server $server, array $data = []): void
    {
        $script = $this->render($server, 'php.uninstall', $data);

        $this->runScript(
            $server,
            $script,
            sprintf('Uninstall PHP version %s', $this->humanReadableVersion())
        );
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function prepareModulesListFromGivenData(array $data): array
    {
        return collect($this->getInstallableModulesFromGivenData($data))->map(function ($module) {
            return 'php' . $this->humanReadableVersion() . '-' . $module;
        })->all();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function getInstallableModulesFromGivenData(array $data): array
    {
        if (!isset($data['modules'])) {
            return ['cli', 'dev', 'sqlite3', 'gd', 'curl', 'mbstring', 'xml', 'zip', 'bcmath', 'intl'];
        } else {
            return (array)$data['modules'];
        }
    }

    /**
     * Additional data for render
     *
     * @param Server $server
     *
     * @return array
     */
    protected function data(Server $server): array
    {
        return [
            'version' => $this->humanReadableVersion(),
        ];
    }
}
