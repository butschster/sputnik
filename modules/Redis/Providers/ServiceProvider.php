<?php

namespace Module\Redis\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'redis',
                'title' => 'Redis Server',
                'categories' => ['database', 'nosql', 'queue'],
                'actions' => [
                    'install' => [
                        'script_view' => 'Redis::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'Redis::scripts.uninstall',
                    'restart' => 'Redis::scripts.restart',
                    'start' => 'Redis::scripts.start',
                    'stop' => 'Redis::scripts.stop',
                ],
            ],
        ]);
    }
}