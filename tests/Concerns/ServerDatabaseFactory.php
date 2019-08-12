<?php

namespace Tests\Concerns;

use App\Models\Server\Database;
use Illuminate\Support\Collection;

trait ServerDatabaseFactory
{

    /**
     * Create a new server database
     *
     * @param array $attributes
     * @param int $times
     * @return Database|Collection
     */
    public function createServerDatabase(array $attributes = [], int $times = null)
    {
        return $this->serverDatabaseFactory($times)->create($attributes);
    }

    /**
     * Make a new server database
     *
     * @param array $attributes
     * @param int $times
     * @return Database|Collection
     */
    public function makeServerDatabase(array $attributes = [], int $times = null)
    {
        return $this->serverDatabaseFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverDatabaseFactory(int $times = null)
    {
        return factory(Database::class, $times);
    }
}
