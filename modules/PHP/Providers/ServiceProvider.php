<?php

namespace Module\PHP\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;
use Domain\Site\Contracts\Entities\Processor;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $categories = ['php', 'webserver_processor'];
        $actions = [
            'install' => [
                'script_view' => 'PHP::scripts.php.install',
                'extensions' => [
                    \Domain\Module\Entities\Action\Extensions\Installer::class,
                    \Module\PHP\PHPSettings::class,
                ],
            ],
            'uninstall' => [
                'script_view' => 'PHP::scripts.php.uninstall',
                'extensions' => [
                    \Module\PHP\PHPSettings::class,
                ],
            ],
        ];

        $this->registerServerModulesFromArray([
            [
                'key' => 'php',
                'title' => 'PHP 5.9',
                'version' => '5.9',
                'categories' => $categories,
                'actions' => $actions,
            ],
            [
                'key' => 'php7.2',
                'title' => 'PHP 7.2',
                'version' => '7.2',
                'categories' => $categories,
                'actions' => $actions,
            ],
            [
                'key' => 'php7.3',
                'title' => 'PHP 7.3',
                'version' => '7.3',
                'categories' => $categories,
                'actions' => $actions,
            ],
            [
                'key' => 'deployer',
                'title' => 'Deployer',
                'dependencies' => ['php*'],
                'categories' => ['php', 'tools', 'deploy'],
                'actions' => [
                    'install' => [
                        'script_view' => 'PHP::scripts.deployer.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'PHP::scripts.deployer.uninstall',
                ],
            ],
            [
                'key' => 'composer',
                'title' => 'Composer',
                'dependencies' => ['php*'],
                'categories' => ['php', 'tools', 'deploy'],
                'actions' => [
                    'install' => [
                        'script_view' => 'PHP::scripts.composer.install',
                        'extensions' => [
                            \Domain\Module\Entities\Action\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'PHP::scripts.composer.uninstall',
                ],
            ],
        ]);


        $this->app[\Domain\Site\Contracts\Configurator::class]->registerProcessor(new class implements Processor
        {
            /** @inheritDoc */
            public function key(): string
            {
                return 'php';
            }

            /** @inheritDoc */
            public function name(): string
            {
                return 'PHP 5.9';
            }
        });

        $this->app[\Domain\Site\Contracts\Configurator::class]->registerProcessor(new class implements Processor
        {
            /** @inheritDoc */
            public function key(): string
            {
                return 'php7.2';
            }

            /** @inheritDoc */
            public function name(): string
            {
                return 'PHP 7.2';
            }
        });

        $this->app[\Domain\Site\Contracts\Configurator::class]->registerProcessor(new class implements Processor
        {
            /** @inheritDoc */
            public function key(): string
            {
                return 'php7.3';
            }

            /** @inheritDoc */
            public function name(): string
            {
                return 'PHP 7.3';
            }
        });
    }
}