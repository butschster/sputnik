<?php

namespace Tests\Unit\Listeners\Server;

use App\Events\Server\Configured;
use App\Listeners\Server\CreateHttpFirewallRules;
use App\Services\Server\FirewallService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Mockery as m;

class CreateHttpFirewallRulesTest extends TestCase
{
    use DatabaseMigrations;

    function test_handle_listener()
    {
        $server = $this->createServer();
        $this->assertCount(0, $server->firewallRules);

        $this->mock(FirewallService::class, function ($mock) {
            $mock->shouldReceive('enableRule')->times(3);
        });

        $listener = $this->app[CreateHttpFirewallRules::class];
        $listener->handle(new Configured($server));

        $this->checkFilrewallRules($server->refresh());
    }

    function test_when_server_configured_firewall_rules_should_be_created()
    {
        $server = $this->createServer();

        event(new Configured($server));

        $this->checkFilrewallRules($server->refresh());
    }

    /**
     * @param $server
     */
    protected function checkFilrewallRules($server): void
    {
        $this->assertCount(3, $server->firewallRules);

        $this->assertDatabaseHas('server_firewall_rules', [
            'name' => 'SSH',
            'port' => 22,
            'server_id' => $server->id
        ]);
        $this->assertDatabaseHas('server_firewall_rules', [
            'name' => 'HTTP',
            'port' => 80,
            'server_id' => $server->id
        ]);
        $this->assertDatabaseHas('server_firewall_rules', [
            'name' => 'HTTPS',
            'port' => 443,
            'server_id' => $server->id
        ]);
    }
}
