<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait ServerKeyFactory
{
    /**
     * Create a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Key|Collection
     */
    public function createServerKey(array $attributes = [], int $times = null)
    {
        return $this->serverKeyFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Key|Collection
     */
    public function makeServerKey(array $attributes = [], int $times = null)
    {
        return $this->serverKeyFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverKeyFactory(int $times = null)
    {
        return factory(Server\Key::class, $times);
    }
}
