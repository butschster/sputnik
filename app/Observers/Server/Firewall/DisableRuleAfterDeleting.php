<?php

namespace App\Observers\Server\Firewall;

use App\Models\Server\Firewall\Rule as FirewallRule;
use App\Services\Server\FirewallService;

class DisableRuleAfterDeleting
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
     * @param FirewallRule $rule
     */
    public function deleted(FirewallRule $rule)
    {
        $this->service->disableRule($rule);
    }
}
