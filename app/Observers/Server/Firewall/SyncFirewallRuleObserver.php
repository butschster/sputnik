<?php

namespace App\Observers\Server\Firewall;

use App\Models\Server\Firewall\Rule;
use App\Services\Server\FirewallService;

class SyncFirewallRuleObserver
{
    /**
     * @var FirewallService
     */
    protected $service;

    /**
     * @param FirewallService $service
     */
    public function __construct(FirewallService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Rule $rule
     */
    public function created(Rule $rule)
    {
        $this->service->enableRule($rule);
    }

    /**
     * @param Rule $rule
     */
    public function deleted(Rule $rule)
    {
        $this->service->disableRule($rule);
    }
}
