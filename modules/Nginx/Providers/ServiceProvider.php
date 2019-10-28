<?php

namespace Module\Nginx\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;
use Domain\Site\Contracts\Entities\Processor;
use Domain\Site\Contracts\Entities\WebServer;
use Domain\Site\ValueObjects\Site;
use Domain\SSH\Contracts\Script;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'nginx',
                'title' => 'Nginx',
                'categories' => ['webserver', 'proxy'],
                'actions' => [
                    'install' => [
                        'script_view' => 'Nginx::scripts.nginx.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                        ],
                        'callbacks' => [
                            \Module\Nginx\Scripts\Callbacks\OpenFirewallRules::class
                        ]
                    ],
                    'uninstall' => 'Nginx::scripts.nginx.uninstall',
                    'restart' => 'Nginx::scripts.nginx.restart',
                    'start' => 'Nginx::scripts.nginx.start',
                    'stop' => 'Nginx::scripts.nginx.stop',
                ],
            ],
        ]);

        $this->app[\Domain\Site\Contracts\Configurator::class]->registerWebServer(new class implements WebServer {
            /** @inheritDoc */
            public function key(): string
            {
                return 'nginx';
            }

            /** @inheritDoc */
            public function name(): string
            {
                return 'Nginx';
            }
        });
    }
}