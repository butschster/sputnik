<?php

namespace App\Scripts\Server\Firewall;

use App\Utils\SSH\Script;

class CheckFirewallStatus extends Script
{
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
