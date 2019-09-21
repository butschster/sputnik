<?php

namespace App\Scripts\Server\Firewall;

use App\Utils\SSH\Script;

class Disable extends Script
{
    /**
     * @var string
     */
    protected $name = 'UFW firewall disable';

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return 'ufw --force disable';
    }
}
