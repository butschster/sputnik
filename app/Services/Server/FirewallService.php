<?php

namespace App\Services\Server;

use App\Models\Server\Firewall\Rule;
use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\EnableRule;

class FirewallService
{
    use Runnable;

    /**
     * Enable firewall rule
     *
     * @param Rule $rule
     */
    public function enableRule(Rule $rule)
    {
        $this->server = $rule->server;

        $script = new EnableRule($rule);

        $this->run($script);
    }

    /**
     * Enable firewall rule
     *
     * @param Rule $rule
     */
    public function disableRule(Rule $rule)
    {
        $this->server = $rule->server;

        $script = new DisableRule($rule);

        $this->run($script);
    }
}
