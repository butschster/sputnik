<?php

namespace Module\PostgreSQL\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'pgsql',
                'title' => 'PostgreSQL',
                'categories' => ['database', 'sql'],
                'actions' => [
                    'install' => [
                        'script_view' => 'PostgreSQL::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                            \Module\PostgreSQL\DatabaseSettings::class
                        ],
                    ],
                    'uninstall' => 'PostgreSQL::scripts.uninstall',
                    'restart' => 'PostgreSQL::scripts.restart',
                    'start' => 'PostgreSQL::scripts.start',
                    'stop' => 'PostgreSQL::scripts.stop',
                ],
            ],
        ]);
    }
}