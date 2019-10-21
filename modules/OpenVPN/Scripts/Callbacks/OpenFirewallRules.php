<?php

namespace Module\OpenVPN\Scripts\Callbacks;

use App\Jobs\Server\OpenFirewallRule;
use App\Models\Server\Task;

class OpenFirewallRules
{
    /**
     * @param Task $task
     */
    public function handle(Task $task): void
    {
        $module = $task->server->getModule('openvpn');

        dispatch(new OpenFirewallRule(
            $task->server, 'OpenVPN', $module->meta['port']
        ));
    }

}