<?php

namespace Domain\SSH\Bash\Firewall;

use Domain\SSH\Contracts\Firewall\UfwRule;

class CommandGenerator
{
    /**
     * @param UfwRule $rule
     *
     * @return string
     * @throws \Exception
     */
    public function generateEnableString(UfwRule $rule): string
    {
        return sprintf('ufw %s %s', $rule->policy(), $this->build($rule));
    }

    /**
     * @param UfwRule $rule
     *
     * @return string
     * @throws \Exception
     */
    public function generateDisableString(UfwRule $rule): string
    {
        return sprintf('ufw delete %s %s', $rule->policy(), $this->build($rule));
    }

    /**
     * @param UfwRule $rule
     *
     * @return string
     * @throws \Exception
     */
    protected function build(UfwRule $rule): string
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
