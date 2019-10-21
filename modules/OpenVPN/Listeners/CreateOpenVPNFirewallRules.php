<?php

namespace Module\OpenVPN\Listeners;

use App\Events\Server\Module\Installed;
use App\Jobs\Server\OpenFirewallRule;

class CreateOpenVPNFirewallRules
{
    /**
     * @param Installed $event
     */
    public function handle(Installed $event): void
    {
        if ($event->module == 'openvpn') {

            $module = $event->server->getModule($event->module);

            dispatch_now(new OpenFirewallRule(
                $event->server,
                'OpenVPN',
                $module->meta['port'],
                'allow',
                false
            ));

        }
    }
}