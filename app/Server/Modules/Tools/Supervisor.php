<?php

namespace App\Server\Modules\Tools;

use App\Contracts\Server\Modules\Configuration;
use App\Models\Server;
use App\Server\Module;

class Supervisor extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['tools', 'daemon'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Supervisor';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'supervisor';
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
                $script = $this->render($server, 'tools.supervisor.install', $data);

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
                $script = $this->render($server, 'tools.supervisor.uninstall');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Uninstall %s', $this->module->title())
                );
            }

            /**
             * Restart module
             *
             * @param Server $server
             */
            public function restart(Server $server): void
            {
                $script = $this->render($server, 'tools.supervisor.restart');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Restart %s', $this->module->title())
                );
            }

            /**
             * Stop module
             *
             * @param Server $server
             */
            public function stop(Server $server): void
            {
                $script = $this->render($server, 'tools.supervisor.stop');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Stop %s', $this->module->title())
                );
            }

            /**
             * Start module
             *
             * @param Server $server
             */
            public function start(Server $server): void
            {
                $script = $this->render($server, 'tools.supervisor.start');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Start %s', $this->module->title())
                );
            }
        };
    }
}
