<?php

namespace Module\Memcached\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'memcached',
                'title' => 'Memcache Server',
                'categories' => ['database', 'nosql', 'cache'],
                'actions' => [
                    'install' => [
                        'script_view' => 'Memcached::scripts.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'Memcached::scripts.uninstall',
                    'restart' => 'Memcached::scripts.restart',
                ],
            ],
        ]);
    }
}