<?php

namespace Tests\Unit\Utils\Ssh;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FirewallCommandGeneratorTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider firewallRulesProvider
     *
     * @param array $data
     * @param string $expected
     * @throws \Exception
     */
    function test_rule_generation($data, $expected)
    {
        $rule = $this->createFirewallRule($data);

        $this->assertEquals($expected, $rule->toBashEnableCommand());
    }

    function firewallRulesProvider()
    {
        return [
            [
                [
                    'port' => 'ssh',
                    'protocol' => null,
                    'from' => null,
                    'policy' => 'allow',
                ],
                'ufw allow ssh'
            ],
            [
                [
                    'port' => '22',
                    'protocol' => null,
                    'from' => null,
                    'policy' => 'allow',
                ],
                'ufw allow 22'
            ],
            [
                [
                    'port' => '22',
                    'protocol' => 'tcp',
                    'from' => null,
                    'policy' => 'allow',
                ],
                'ufw allow 22/tcp'
            ],
            [
                [
                    'port' => '22',
                    'protocol' => 'udp',
                    'from' => null,
                    'policy' => 'allow',
                ],
                'ufw allow 22/udp'
            ],
            [
                [
                    'port' => '22',
                    'protocol' => null,
                    'from' => null,
                    'policy' => 'deny',
                ],
                'ufw deny 22'
            ],
            [
                [
                    'port' => '6000:6007',
                    'protocol' => 'tcp',
                    'from' => null,
                    'policy' => 'allow',
                ],
                'ufw allow 6000:6007/tcp'
            ],
            [
                [
                    'port' => '6000:6007',
                    'protocol' => null,
                    'from' => null,
                    'policy' => 'allow',
                ],
                'ufw allow 6000:6007'
            ],
            [
                [
                    'port' => null,
                    'protocol' => null,
                    'from' => '15.15.15.51',
                    'policy' => 'allow',
                ],
                'ufw allow from 15.15.15.51'
            ],
            [
                [
                    'port' => null,
                    'protocol' => null,
                    'from' => '15.15.15.51',
                    'policy' => 'deny',
                ],
                'ufw deny from 15.15.15.51'
            ],
            [
                [
                    'port' => null,
                    'protocol' => null,
                    'from' => '15.15.15.51/10',
                    'policy' => 'allow',
                ],
                'ufw allow from 15.15.15.51/10'
            ],
            [
                [
                    'port' => 22,
                    'protocol' => null,
                    'from' => '15.15.15.51',
                    'policy' => 'allow',
                ],
                'ufw allow from 15.15.15.51 to any port 22'
            ],
            [
                [
                    'port' => 22,
                    'protocol' => null,
                    'from' => '15.15.15.51',
                    'policy' => 'deny',
                ],
                'ufw deny from 15.15.15.51 to any port 22'
            ],
            [
                [
                    'port' => 22,
                    'protocol' => 'tcp',
                    'from' => '15.15.15.51',
                    'policy' => 'allow',
                ],
                'ufw allow from 15.15.15.51 to any port 22/tcp'
            ],
            [
                [
                    'port' => 22,
                    'protocol' => null,
                    'from' => '15.15.15.51/24',
                    'policy' => 'allow',
                ],
                'ufw allow from 15.15.15.51/24 to any port 22'
            ],
            [
                [
                    'port' => 22,
                    'protocol' => 'udp',
                    'from' => '15.15.15.51/24',
                    'policy' => 'allow',
                ],
                'ufw allow from 15.15.15.51/24 to any port 22/udp'
            ]
        ];
    }
}
