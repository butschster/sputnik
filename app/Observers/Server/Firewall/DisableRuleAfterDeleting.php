<?php

namespace App\Observers\Server\Firewall;

use App\Models\Server\Firewall;
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
     * @param Firewall $rule
     */
    public function deleted(Firewall $rule)
    {
        $this->service->disableRule($rule);
    }
}
