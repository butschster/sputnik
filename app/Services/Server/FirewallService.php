<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Models\Server\Firewall\Rule;
use App\Scripts\Server\Firewall\CheckFirewallStatus;
use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\EnableRule;
use App\Services\Server\Firewall\StatusParser;
use App\Services\Task\Contracts\Task;
use Illuminate\Support\Collection;

class FirewallService
{
    use Runnable;

    /**
     * @param Server $server
     *
     * @return Collection
     */
    public function getAvailableRules(Server $server): Collection
    {
        $this->setServer($server);

        $task = $this->run(new CheckFirewallStatus());

        return (new StatusParser($task->output))->getRules();
    }

    /**
     * Ensures the firewall status from the command output is active
     *
     * @param Server $server
     * @return bool
     * @throws \Exception
     */
    public function checkFirewallStatus(Server $server): bool
    {
        $this->setServer($server);

        $task = $this->run(new CheckFirewallStatus());

        return (new StatusParser($task->output))->isActive();
    }

    /**
     * Enable firewall rule
     *
     * @param Rule $rule
     *
     * @return Task
     */
    public function enableRule(Rule $rule): Task
    {
        $this->setServer($rule->server);

        return $this->run(new EnableRule($rule));
    }

    /**
     * Enable firewall rule
     *
     * @param Rule $rule
     *
     * @return Task
     */
    public function disableRule(Rule $rule): Task
    {
        $this->setServer($rule->server);

        return $this->run(new DisableRule($rule));
    }
}
