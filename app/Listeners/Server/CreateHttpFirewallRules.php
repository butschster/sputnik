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
    protected $webserverRules = [
        ['name' => 'SSH', 'port' => 22, 'policy' => 'allow', 'editable' => false],
        ['name' => 'HTTP', 'port' => 80, 'policy' => 'allow'],
        ['name' => 'HTTPS', 'port' => 443, 'policy' => 'allow'],
    ];

    /**
     * @var array
     */
    protected $openVPNRules = [
        ['name' => 'SSH', 'port' => 22, 'policy' => 'allow', 'editable' => false],
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
        $rules = [];
        switch ($event->server->type) {
            case 'webserver':
                $rules = $this->webserverRules;
                break;
            case 'openvpn':
                $rules = $this->openVPNRules;
                $rules[] = [
                    'name' => 'OpenVPN',
                    'port' => $event->server->toConfiguration()->port(),
                    'protocol' => $event->server->toConfiguration()->protocol(),
                    'policy' => 'allow',
                    'editable' => false,
                ];
                break;
        }

        foreach ($rules as $rule) {
            $event->server->firewallRules()->create($rule);
        }

        $this->service->enable($event->server);
    }
}
