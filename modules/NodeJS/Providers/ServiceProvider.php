<?php

namespace Module\NodeJS\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'nodejs',
                'title' => 'Node.js',
                'categories' => ['javascript', 'webserver'],
                'actions' => [
                    'install' => [
                        'script_view' => 'NodeJS::scripts.nodejs.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                            \Module\NodeJS\NodeJSSettings::class
                        ],
                    ],
                    'uninstall' => 'NodeJS::scripts.nodejs.uninstall',
                ],
            ],
            [
                'key' => 'yarn',
                'title' => 'Yarn',
                'categories' => ['javascript'],
                'actions' => [
                    'install' => [
                        'script_view' => 'NodeJS::scripts.yarn.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'NodeJS::scripts.yarn.uninstall',
                ],
            ],
        ]);
    }
}