<?php

namespace Module\Nginx\Scripts\Callbacks;

use App\Contracts\Scripts\Callback;
use App\Jobs\Server\OpenFirewallRule;
use App\Models\Server\Task;

class OpenFirewallRules implements Callback
{
    /**
     * @param Task $task
     */
    public function handle(Task $task): void
    {
        dispatch(new OpenFirewallRule(
            $task->server, 'HTTP', 80
        ));

        dispatch(new OpenFirewallRule(
            $task->server, 'HTTPS', 443
        ));
    }
}