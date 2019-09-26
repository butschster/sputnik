<?php

namespace App\Server\Modules\Security;

use App\Contracts\Server\Modules\Configuration;
use App\Models\Server;
use App\Server\Module;

class Fail2Ban extends Module
{
    /**
     * Get module categories
     * @return array
     */
    public function categories(): array
    {
        return ['security', 'tools'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Fail2Ban';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'fail2ban';
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
                $script = $this->render($server, 'security.fail2ban.install', $data);

                $this->installModule(
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
                $script = $this->render($server, 'security.fail2ban.uninstall');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Uninstall %s', $this->module->title())
                );
            }
        };
    }
}
