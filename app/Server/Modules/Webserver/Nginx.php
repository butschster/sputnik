<?php

namespace App\Server\Modules\Webserver;

use App\Contracts\Server\Modules\Configuration;
use App\Jobs\Server\OpenFirewallRule;
use App\Models\Server;
use App\Server\Module;

class Nginx extends Module
{
    protected static function boot()
    {
        parent::boot();

        static::installed(function (Server $server) {
            dispatch(new OpenFirewallRule(
                $server, 'HTTP', 80
            ));

            dispatch(new OpenFirewallRule(
                $server, 'HTTPS', 443
            ));
        });
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Nginx';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'nginx';
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
             * @throws \Throwable
             */
            public function install(Server $server, array $data): array
            {
                $data = $this->prepareData($server, $data);

                $script = $this->render($server, 'webserver.nginx.install', $data);

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
                $script = $this->render($server, 'webserver.nginx.uninstall');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Unnstall %s', $this->module->title())
                );
            }

            /**
             * Restart module
             *
             * @param Server $server
             */
            public function restart(Server $server): void
            {
                $script = $this->render($server, 'webserver.nginx.restart');

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
                $script = $this->render($server, 'webserver.nginx.stop');

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
                $script = $this->render($server, 'webserver.nginx.start');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Start %s', $this->module->title())
                );
            }
        };
    }
}