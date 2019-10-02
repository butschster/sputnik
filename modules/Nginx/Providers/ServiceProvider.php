<?php

namespace Module\Nginx\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

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
                            \App\Server\Modules\Actions\Extensions\Installer::class,
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
    }
}