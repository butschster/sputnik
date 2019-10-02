<?php

namespace Module\MongoDB\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'mongodb',
                'title' => 'MongoDB Server',
                'categories' => ['database', 'nosql'],
                'actions' => [
                    'install' => [
                        'script_view' => 'MongoDB::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'MongoDB::scripts.uninstall',
                    'restart' => 'MongoDB::scripts.restart',
                    'start' => 'MongoDB::scripts.start',
                    'stop' => 'MongoDB::scripts.stop',
                ],
            ],
        ]);
    }
}