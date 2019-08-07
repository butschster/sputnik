<?php

namespace Tests\Unit\Services\Server;

use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\EnableRule;
use App\Services\Server\FirewallService;
use App\Utils\SSH\Contracts\ProcessExecutor;
use App\Utils\SSH\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FirewallServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_rule_can_be_enabled()
    {
        $this->spyRunningTasks();

        $rule = $this->createFirewallRule();

        $this->getFirewallService()->enableRule($rule);

        $this->assertExecutedTaskScript(
            new EnableRule($rule)
        );
    }

    function test_a_rule_can_be_disabled()
    {
        $this->spyRunningTasks();

        $rule = $this->createFirewallRule();

        $this->getFirewallService()->disableRule($rule);

        $this->assertExecutedTaskScript(
            new DisableRule($rule)
        );
    }

    function test_firewall_status_should_return_false_if_it_inactive()
    {
        $server = $this->createServer();

        $this->mock(ProcessExecutor::class, function ($mock) {
            $mock->shouldReceive('run')->andReturnUsing(function ($script) {
                return new Response(0, 'Status: inactive');
            });
        });

        $this->assertFalse(
            $this->getFirewallService()->checkFirewallStatus($server)
        );
    }

    function test_firewall_status_should_return_tru_if_it_active()
    {
        $server = $this->createServer();

        $this->mock(ProcessExecutor::class, function ($mock) {
            $mock->shouldReceive('run')->andReturnUsing(function ($script) {
                return new Response(0, 'Status: active');
            });
        });

        $this->assertTrue(
            $this->getFirewallService()->checkFirewallStatus($server)
        );
    }

    function test_gets_available_firewall_rules()
    {
        $server = $this->createServer();

        $this->mock(ProcessExecutor::class, function ($mock) {
            $mock->shouldReceive('run')->andReturnUsing(function ($script) {
                return new Response(0, $this->getUfwStatus());
            });
        });

        $this->assertEquals([
            "ufw allow 22",
            "ufw allow 80",
            "ufw allow from 1.2.3.4 to any port 443",
        ], $this->getFirewallService()->getAvailableRules($server)->map->toBashEnableCommand()->toArray());
    }


    /**
     * @return FirewallService
     */
    protected function getFirewallService(): FirewallService
    {
        return $this->app[FirewallService::class];
    }

    public function getUfwStatus(): string
    {
        $status = <<<EOL
Status: active

To                         Action      From
--                         ------      ----
22                         ALLOW       Anywhere
80                         ALLOW       Anywhere
443                        ALLOW       1.2.3.4
EOL;

        return $status;
    }
}
