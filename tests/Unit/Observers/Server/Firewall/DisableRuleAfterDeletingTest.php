<?php

namespace Tests\Unit\Observers\Server\Firewall;

use App\Services\Server\FirewallService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DisableRuleAfterDeletingTest extends TestCase
{
    use DatabaseMigrations;

    function test_rule_can_be_deleted_from_server_it_it_was_deleted()
    {
        $rule = $this->createFirewallRule();

        $this->mock(FirewallService::class, function($mock) use($rule) {
            $mock->shouldReceive('disableRule')->once()->with($rule);
        });

        $rule->delete();
    }
}
