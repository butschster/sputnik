<?php

namespace App\Services\Server;

use App\Models\Server\Firewall\Rule;
use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\EnableRule;
use App\Services\Task\Contracts\Task;

class FirewallService
{
    use Runnable;

    /**
     * Enable firewall rule
     *
     * @param Rule $rule
     *
     * @return Task
     */
    public function enableRule(Rule $rule): Task
    {
        $this->server = $rule->server;

        return $this->run(
            new EnableRule($rule)
        );
    }

    /**
     * Enable firewall rule
     *
     * @param Rule $rule
     * @return Task
     */
    public function disableRule(Rule $rule): Task
    {
        $this->server = $rule->server;

        return $this->run(
            new DisableRule($rule)
        );
    }
}
