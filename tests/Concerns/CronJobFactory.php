<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait CronJobFactory
{
    /**
     * Create a new cron job
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\CronJob|Collection
     */
    public function createCronJob(array $attributes = [], int $times = null)
    {
        return $this->cronJobFactory($times)->create($attributes);
    }

    /**
     * Make a new cron job
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\CronJob|Collection
     */
    public function makeCronJob(array $attributes = [], int $times = null)
    {
        return $this->cronJobFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function cronJobFactory(int $times = null)
    {
        return factory(Server\CronJob::class, $times);
    }
}
