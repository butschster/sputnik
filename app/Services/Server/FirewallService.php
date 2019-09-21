<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Models\Server\Firewall\Rule;
use App\Scripts\Server\Firewall\Callbacks\MarkAsDisabled;
use App\Scripts\Server\Firewall\Callbacks\MarkAsEnabled;
use App\Scripts\Server\Firewall\CheckFirewallStatus;
use App\Scripts\Server\Firewall\Disable;
use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\Enable;
use App\Scripts\Server\Firewall\EnableRule;
use App\Services\Task\Contracts\Task;
use App\Utils\SSH\Firewall\StatusParser;
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
     * Enable firewall
     *
     * @param Server $server
     * @return Task
     */
    public function enable(Server $server): Task
    {
        $this->setServer($server);

        return $this->run(new Enable(), [
            'then' => [
                MarkAsEnabled::class,
            ],
        ]);
    }

    /**
     * Disable firewall
     *
     * @param Server $server
     * @return Task
     */
    public function disable(Server $server): Task
    {
        $this->setServer($server);

        return $this->run(new Disable(), [
            'then' => [
                MarkAsDisabled::class,
            ],
        ]);
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
        $this->setOwner($rule);

        return $this->runJob(new EnableRule($rule));
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
        $this->setOwner($rule);

        return $this->runJob(new DisableRule($rule));
    }
}
