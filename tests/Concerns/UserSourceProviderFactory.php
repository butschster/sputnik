<?php

namespace Tests\Concerns;

use App\Models\User\SourceProvider;
use Illuminate\Support\Collection;

trait UserSourceProviderFactory
{
    /**
     * Create a new source provider
     *
     * @param array $attributes
     * @param int $times
     * @return SourceProvider|Collection
     */
    public function createSourceProvider(array $attributes = [], int $times = null)
    {
        return $this->sourceProviderFactory($times)->create($attributes);
    }

    /**
     * Make a new server SourceProvider
     *
     * @param array $attributes
     * @param int $times
     * @return SourceProvider|Collection
     */
    public function makeSourceProvider(array $attributes = [], int $times = null)
    {
        return $this->sourceProviderFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\SourceProvider\Eloquent\FactoryBuilder
     */
    public function sourceProviderFactory(int $times = null)
    {
        return factory(SourceProvider::class, $times);
    }
}
