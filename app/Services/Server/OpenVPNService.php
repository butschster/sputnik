<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Scripts\Server\Firewall\CheckFirewallStatus;
use App\Scripts\Server\OpenVPN\GetClientConfig;

class OpenVPNService
{
    use Runnable;

    /**
     * @param Server $server
     * @param string $user
     *
     * @return string
     */
    public function getClientConfig(Server $server, string $user): string
    {
        $this->setServer($server);

        $task = $this->run(new GetClientConfig($user));

        return $task->output;
    }
}