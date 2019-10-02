<?php

namespace Module\Supervisor\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'supervisor',
                'title' => 'Supervisor',
                'categories' => ['tools', 'daemon'],
                'actions' => [
                    'install' => [
                        'script_view' => 'Supervisor::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'Supervisor::scripts.uninstall',
                    'restart' => 'Supervisor::scripts.restart',
                    'start' => 'Supervisor::scripts.start',
                    'stop' => 'Supervisor::scripts.stop',
                ],
            ]
        ]);
    }
}