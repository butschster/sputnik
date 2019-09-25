<?php

namespace App\Server\Modules\PHP;

use App\Contracts\Server\Modules\Configuration;
use App\Models\Server;

class Composer extends \App\Server\Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['php', 'tools'];
    }

    /**
     * Get module dependencies
     * @return array
     */
    public function dependencies(): array
    {
        return ['php*'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Composer';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'composer';
    }

    /**
     * Get module configuration
     * @return Configuration
     */
    public function configuration(): Configuration
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
                $script = $this->render($server, 'php.composer.install', $data);

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
                $script = $this->render($server, 'php.composer.uninstall');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Uninstall %s', $this->module->title())
                );
            }
        };
    }
}
