<?php

namespace Tests\Unit\Services\Server;

use App\Scripts\Server\Firewall\DisableRule;
use App\Scripts\Server\Firewall\EnableRule;
use App\Services\Server\FirewallService;
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

    /**
     * @return FirewallService
     */
    protected function getFirewallService(): FirewallService
    {
        return $this->app[FirewallService::class];
    }
}
