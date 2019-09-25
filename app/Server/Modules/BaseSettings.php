<?php

namespace App\Server\Modules;

use App\Models\Server;
use App\Server\Module;

class BaseSettings extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['base'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Base settings';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'base_settings';
    }

    /**
     * @return array
     */
    public function defaultSettings(): array
    {
        return [
            'timezone' => 'UTC'
        ];
    }

    /**
     * Get module configuration
     * @return \App\Contracts\Server\Modules\Configuration
     */
    public function configuration(): \App\Contracts\Server\Modules\Configuration
    {
        return new class($this) extends \App\Server\Modules\Configuration
        {

            /**
             * Install module
             *
             * @param Server $server
             * @param array $data
             * @return array
             */
            public function install(Server $server, array $data): array
            {
                $data = $this->prepareData($server, $data);

                $script = $this->render($server, 'base.install', $data);

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Install %s', $this->module->title())
                );

                return $data;
            }

            /**
             * Uninstall module
             *
             * @param Server $server
             */
            public function uninstall(Server $server): void
            {

            }
        };
    }

    /**
     * Get module dictionaries
     * @return array
     */
    public function dictionaries(): array
    {
        return [
            //'timezones' => \DateTimeZone::listIdentifiers(),
        ];
    }
}