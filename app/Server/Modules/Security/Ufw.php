<?php

namespace App\Server\Modules\Security;

use App\Contracts\Server\Modules\Configuration;
use App\Models\Server;
use App\Server\Module;

class Ufw extends Module
{
    /**
     * Get module categories
     * @return array
     */
    public function categories(): array
    {
        return ['security', 'tools', 'firewall'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'ufw';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'ufw';
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
             */
            public function install(Server $server, array $data): void
            {
                $script = $this->render($server, 'security.ufw.install', $data);

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Install %s', $this->module->title())
                );
            }

            /**
             * Uninstall module
             *
             * @param Server $server
             * @param array $data
             */
            public function uninstall(Server $server, array $data): void
            {
                $script = $this->render($server, 'security.ufw.uninstall', $data);

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Uninstall %s', $this->module->title())
                );
            }
        };
    }
}
