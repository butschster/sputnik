<?php

namespace Module\Mysql\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $categories = ['database', 'sql'];
        $conflicts = ['mysql*', 'mariadb'];

        $actions = [
            'install' => [
                'script_view' => 'Mysql::scripts.:module.install',
                'extensions' => [
                    \App\Server\Modules\Actions\Extensions\Installer::class,
                    \Module\Mysql\DatabaseSettings::class,
                ],
            ],
            'uninstall' => 'Mysql::scripts.:module.uninstall',
            'restart' => 'Mysql::scripts.:module.restart',
            'start' => 'Mysql::scripts.:module.start',
            'stop' => 'Mysql::scripts.:module.stop',
        ];

        $this->registerServerModulesFromArray([
            [
                'key' => 'mysql56',
                'title' => 'MySQL 5.6',
                'categories' => $categories,
                'conflicts' => $conflicts,
                'actions' => $actions,
            ],
            [
                'key' => 'mysql8',
                'title' => 'MySQL 8.0',
                'categories' => $categories,
                'conflicts' => $conflicts,
                'actions' => $actions,
            ],
            [
                'key' => 'mariadb',
                'title' => 'MariaDB',
                'categories' => $categories,
                'conflicts' => $conflicts,
                'actions' => $actions,
            ],
        ]);
    }
}