<?php

namespace Module\OpenVPN\Listeners;

use App\Jobs\Server\OpenFirewallRule;
use Domain\Module\Events\Module\Installed;

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