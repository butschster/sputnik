<?php

namespace Module\OpenVPN\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'openvpn',
                'title' => 'OpenVPN',
                'categories' => ['tools', 'vpn'],
                'actions' => [
                    'install' => [
                        'script_view' => 'OpenVPN::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                            \Module\OpenVPN\OpenVPNSettings::class
                        ],
                        'callbacks' => [
                            \Module\OpenVPN\Scripts\Callbacks\OpenFirewallRules::class
                        ]
                    ],
                    'uninstall' => 'OpenVPN::scripts.uninstall',
                    'restart' => 'OpenVPN::scripts.restart',
                    'start' => 'OpenVPN::scripts.start',
                    'stop' => 'OpenVPN::scripts.stop',
                ],
            ],
        ]);
    }
}