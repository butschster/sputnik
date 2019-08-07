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
     * @var array
     */
    protected $rules = [
        ['name' => 'SSH', 'port' => 22, 'policy' => 'allow', 'editable' => false],
        ['name' => 'HTTP', 'port' => 80, 'policy' => 'allow'],
        ['name' => 'HTTPS', 'port' => 443, 'policy' => 'allow'],
    ];

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
    public function handle(Configured $event): void
    {
        foreach ($this->rules as $rule) {
            $event->server->firewallRules()->create($rule);
        }
    }
}
