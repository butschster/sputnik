<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use App\Jobs\Server\OpenFirewallRule;
use App\Services\Server\FirewallService;

class CreateSSHFirewallRules
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
    public function handle(Configured $event): void
    {
        dispatch_now(new OpenFirewallRule(
            $event->server,
            'SSH',
            $event->server->ssh_port,
            'allow',
            false
        ));

        $this->service->enable($event->server);
    }
}
