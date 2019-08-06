<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FirewallRuleTest extends TestCase
{
    use DatabaseMigrations;

    function test_the_protocol_can_be_null()
    {
        $rule = $this->createFirewallRule([
            'protocol' => null
        ]);

        $this->assertNull($rule->protocol());
    }

    function test_the_protocol_can_be_not_null()
    {
        $rule = $this->createFirewallRule([
            'protocol' => 'tcp'
        ]);

        $this->assertEquals('tcp', $rule->protocol());
    }

    function test_the_port_can_be_null()
    {
        $rule = $this->createFirewallRule([
            'port' => null
        ]);

        $this->assertNull($rule->port());
    }

    function test_the_port_can_be_number()
    {
        $rule = $this->createFirewallRule([
            'protocol' => null,
            'port' => 22
        ]);

        $this->assertEquals(22, $rule->port());
    }

    function test_the_port_can_be_range()
    {
        $rule = $this->createFirewallRule([
            'protocol' => null,
            'port' => '22:33'
        ]);

        $this->assertEquals('22:33', $rule->port());
    }

    function test_the_port_can_have_protocol_if_it_set()
    {
        $rule = $this->createFirewallRule([
            'protocol' => 'udp',
            'port' => '22'
        ]);

        $this->assertEquals('22/udp', $rule->port());
    }

    function test_the_port_can_be_null_if_protocol_set_but_port_not_set()
    {
        $rule = $this->createFirewallRule([
            'protocol' => 'udp',
            'port' => null
        ]);

        $this->assertNull($rule->port());
    }

    function test_get_policy()
    {
        $rule = $this->createFirewallRule([
            'policy' => 'allow'
        ]);

        $this->assertEquals('allow', $rule->policy());
    }

    function test_the_from_can_be_null()
    {
        $rule = $this->createFirewallRule([
            'from' => null
        ]);

        $this->assertNull($rule->from());
    }

    function test_the_from_can_be_ip()
    {
        $rule = $this->createFirewallRule([
            'from' => '127.0.0.1'
        ]);

        $this->assertEquals('127.0.0.1', $rule->from());
    }

    function test_the_from_can_be_ip_range()
    {
        $rule = $this->createFirewallRule([
            'from' => '127.0.0.1/24'
        ]);

        $this->assertEquals('127.0.0.1/24', $rule->from());
    }

    function test_it_can_generate_enable_string()
    {
        $rule = $this->createFirewallRule([
            'protocol' => 'udp',
            'port' => '22',
            'from' => null,
            'policy' => 'allow'
        ]);

        $this->assertEquals('ufw allow 22/udp', $rule->toBashEnableCommand());
    }

    function test_it_can_generate_disble_string()
    {
        $rule = $this->createFirewallRule([
            'protocol' => 'udp',
            'port' => '22',
            'from' => null,
            'policy' => 'allow'
        ]);

        $this->assertEquals('ufw delete allow 22/udp', $rule->toBashDisableCommand());
    }
}
