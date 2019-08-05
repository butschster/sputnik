<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait ServerFactory
{

    /**
     * Create a new server
     *
     * @param array $attributes
     * @param int $times
     * @return Server|Collection
     */
    public function createServer(array $attributes = [], int $times = null)
    {
        $this->mockSshGenerator();

        return $this->serverFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     * @return Server|Collection
     */
    public function makeServer(array $attributes = [], int $times = null)
    {
        return $this->serverFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverFactory(int $times = null)
    {
        return factory(Server::class, $times);
    }

}
