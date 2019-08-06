<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait ServerEventFactory
{
    /**
     * Create a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Event|Collection
     */
    public function createServerEvent(array $attributes = [], int $times = null)
    {
        return $this->serverEventFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Event|Collection
     */
    public function makeServerEvent(array $attributes = [], int $times = null)
    {
        return $this->serverEventFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverEventFactory(int $times = null)
    {
        return factory(Server\Event::class, $times);
    }
}
