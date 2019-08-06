<?php

namespace App\Services\Server;

use App\Models\Server\Firewall;
use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\EnableRule;

class FirewallService
{
    use Runnable;

    /**
     * Enable firewall rule
     *
     * @param Firewall $rule
     */
    public function enableRule(Firewall $rule)
    {
        $this->server = $rule->server;

        $script = new EnableRule($rule);

        $this->run($script);
    }

    /**
     * Enable firewall rule
     *
     * @param Firewall $rule
     */
    public function disableRule(Firewall $rule)
    {
        $this->server = $rule->server;

        $script = new DisableRule($rule);

        $this->run($script);
    }
}
