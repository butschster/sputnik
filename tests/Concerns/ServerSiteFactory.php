<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait ServerSiteFactory
{
    /**
     * Create a new server site
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Site|Collection
     */
    public function createServerSite(array $attributes = [], int $times = null)
    {
        return $this->serverSiteFactory($times)->create($attributes);
    }

    /**
     * Make a new server site
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Site|Collection
     */
    public function makeServerSite(array $attributes = [], int $times = null)
    {
        return $this->serverSiteFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverSiteFactory(int $times = null)
    {
        return factory(Server\Site::class, $times);
    }
}
