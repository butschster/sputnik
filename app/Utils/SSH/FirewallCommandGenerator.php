<?php

namespace App\Utils\SSH;

use App\Models\Server\Firewall\Rule;

class FirewallCommandGenerator
{
    /**
     * @param Rule $rule
     * @return string
     *
     * @throws \Exception
     */
    public function generateEnableString(Rule $rule): string
    {
        return sprintf('ufw %s %s', $rule->policy(), $this->build($rule));
    }

    /**
     * @param Rule $rule
     * @return string
     *
     * @throws \Exception
     */
    public function generateDisableString(Rule $rule): string
    {
        return sprintf('ufw delete %s %s', $rule->policy(), $this->build($rule));
    }

    /**
     * @param Rule $rule
     * @return string
     * @throws \Exception
     */
    protected function build(Rule $rule): string
    {
        if (!$rule->hasFrom() && !$rule->hasPort()) {
            throw new \Exception('Rule should have at least port or ip address from');
        }

        if (!$rule->hasFrom()) {
            return $rule->port();
        }

        return 'from ' . $rule->from() . ($rule->hasPort() ? ' to any port ' . $rule->port() : '');
    }
}
