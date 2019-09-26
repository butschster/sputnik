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
     * @return array
     * @throws \Throwable
     */
    public function install(Server $server, array $data = []): array
    {
        $data['modules'] = $this->getInstallableModulesFromGivenData($data);
        $data['server_modules'] = $this->prepareModulesListFromGivenData($data);

        $data = $this->prepareData($server, $data);

        $script = $this->render($server, 'php.install', $data);

        $this->installModule(
            $server,
            $script,
            sprintf('Install PHP version %s', $this->humanReadableVersion())
        );

        return $data;
    }

    /**
     * Uninstall module
     *
     * @param Server $server
     *
     * @throws \Throwable
     */
    public function uninstall(Server $server): void
    {
        $script = $this->render($server, 'php.uninstall');

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
        return (array) $data['modules'];
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
