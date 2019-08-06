<?php

namespace App\Utils\SSH;

use App\Models\Server\Firewall;

class FirewallCommandGenerator
{
    /**
     * @param Firewall $rule
     * @return string
     *
     * @throws \Exception
     */
    public function generateEnableString(Firewall $rule): string
    {
        return sprintf('ufw %s %s', $rule->policy, $this->build($rule));
    }

    /**
     * @param Firewall $rule
     * @return string
     *
     * @throws \Exception
     */
    public function generateDisableString(Firewall $rule): string
    {
        return sprintf('ufw delete %s %s', $rule->policy, $this->build($rule));
    }

    /**
     * @param Firewall $rule
     * @return string
     * @throws \Exception
     */
    protected function build(Firewall $rule): string
    {
        if (empty($rule->from) && empty($rule->port)) {
            throw new \Exception('Rule should have at least port or ip address from');
        }

        $port = '';

        if (!empty($rule->port)) {
            $port = $rule->port . (!empty($rule->protocol) ? '/' . $rule->protocol : '');
        }

        if (empty($rule->from)) {
            return $port;
        }

        return 'from ' . $rule->from . (!empty($port) ? ' to any port ' . $port : '');
    }
}
