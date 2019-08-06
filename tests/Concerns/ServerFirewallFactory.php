<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait ServerFirewallFactory
{
    /**
     * Create a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Firewall\Rule|Collection
     */
    public function createFirewallRule(array $attributes = [], int $times = null)
    {
        return $this->firewallRuleFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Firewall\Rule|Collection
     */
    public function makeFirewallRule(array $attributes = [], int $times = null)
    {
        return $this->firewallRuleFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function firewallRuleFactory(int $times = null)
    {
        return factory(Server\Firewall\Rule::class, $times);
    }
}
