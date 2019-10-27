<?php

namespace Module\Fail2Ban\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'fail2ban',
                'title' => 'Fail2ban',
                'categories' => ['security', 'tools'],
                'actions' => [
                    'install' => [
                        'script_view' => 'Fail2Ban::scripts.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'Fail2Ban::scripts.uninstall',
                ],
            ]
        ]);
    }
}