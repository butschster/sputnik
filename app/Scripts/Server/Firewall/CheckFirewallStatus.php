<?php

namespace App\Scripts\Server\Firewall;

use Domain\SSH\Script;

class CheckFirewallStatus extends Script
{
    /**
     * @var string
     */
    protected $name = 'Get UFW firewall status';

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return 'ufw status';
    }
}
