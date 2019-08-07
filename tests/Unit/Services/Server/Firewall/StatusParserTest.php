<?php

namespace Tests\Unit\Services\Server\Firewall;

use App\Services\Server\Firewall\StatusParser;
use Tests\TestCase;

class StatusParserTest extends TestCase
{
    function test_status_can_be_active()
    {
        $this->assertTrue($this->getStatusParser('Status: active')->isActive());
    }

    function test_status_can_be_inactive()
    {
        $this->assertFalse($this->getStatusParser('Status: inactive')->isActive());

        $this->assertFalse($this->getStatusParser('')->isActive());
    }

    function test_parse_rules_list()
    {
        $rules = $this->getStatusParser($this->getUfwStatus())->getRules();

        $this->assertEquals([
            "ufw allow 22/tcp",
            "ufw allow 22",
            "ufw allow 67:68/tcp",
            "ufw allow 55999:56999/udp",
            "ufw allow from 123.45.67.0/24 to any port 80/tcp",
            "ufw allow 80",
            "ufw allow from 1.2.3.4 to any port 443",
        ], $rules->map->toBashEnableCommand()->toArray());
    }

    public function getStatusParser(string $status)
    {
        return new StatusParser($status);
    }

    public function getUfwStatus(): string
    {
        $status = <<<EOL
Status: active

To                         Action      From
--                         ------      ----
22/tcp                     ALLOW       Anywhere
22                         ALLOW       Anywhere
67:68/tcp                  ALLOW       Anywhere
55999:56999/udp            ALLOW       Anywhere
80/tcp                     ALLOW       123.45.67.0/24   
80                         ALLOW       Anywhere
443                        ALLOW       1.2.3.4
22/tcp (v6)                DENY        Anywhere (v6)
22 (v6)                    ALLOW       Anywhere (v6)
80/tcp (v6)                DENY        Anywhere (v6)
80 (v6)                    ALLOW       Anywhere (v6)
443 (v6)                   ALLOW       Anywhere (v6)
EOL;

        return $status;
    }
}
