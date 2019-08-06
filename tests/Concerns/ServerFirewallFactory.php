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
     * @return Server\Firewall|Collection
     */
    public function createServerFirewall(array $attributes = [], int $times = null)
    {
        return $this->serverFirewallFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Firewall|Collection
     */
    public function makeServerFirewall(array $attributes = [], int $times = null)
    {
        return $this->serverFirewallFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverFirewallFactory(int $times = null)
    {
        return factory(Server\Firewall::class, $times);
    }
}
