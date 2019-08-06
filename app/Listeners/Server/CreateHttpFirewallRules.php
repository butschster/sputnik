<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use App\Services\Server\FirewallService;

class CreateHttpFirewallRules
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
     * @param Configured $event
     */
    public function handle(Configured $event)
    {
        $event->server->firewallRules()->create(['name' => 'SSH', 'port' => 22, 'policy' => 'allow', 'editable' => false]);

        $this->service->enableRule(
            $event->server->firewallRules()->create(['name' => 'HTTP', 'port' => 80, 'policy' => 'allow'])
        );

        $this->service->enableRule(
            $event->server->firewallRules()->create(['name' => 'HTTPS', 'port' => 443, 'policy' => 'allow'])
        );
    }
}
