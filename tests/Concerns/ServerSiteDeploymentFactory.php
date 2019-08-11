<?php

namespace Tests\Concerns;

use App\Models\Server\Site\Deployment;
use Illuminate\Support\Collection;

trait ServerSiteDeploymentFactory
{
    /**
     * Create a new server site deployment
     *
     * @param array $attributes
     * @param int $times
     * @return Deployment|Collection
     */
    public function createServerSiteDeployment(array $attributes = [], int $times = null)
    {
        return $this->serverSiteDeploymentFactory($times)->create($attributes);
    }

    /**
     * Make a new server site deployment
     *
     * @param array $attributes
     * @param int $times
     * @return Deployment|Collection
     */
    public function makeServerSiteDeployment(array $attributes = [], int $times = null)
    {
        return $this->serverSiteDeploymentFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverSiteDeploymentFactory(int $times = null)
    {
        return factory(Deployment::class, $times);
    }
}
