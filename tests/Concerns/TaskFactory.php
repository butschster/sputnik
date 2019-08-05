<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait TaskFactory
{
    /**
     * Create a new task
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Task|Collection
     */
    public function createTask(array $attributes = [], int $times = null)
    {
        $this->mockSshGenerator();

        return $this->taskFactory($times)->create($attributes);
    }

    /**
     * Make a new task
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Task|Collection
     */
    public function makeTask(array $attributes = [], int $times = null)
    {
        $this->mockSshGenerator();

        return $this->taskFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function taskFactory(int $times = null)
    {
        return factory(Server\Task::class, $times);
    }
}
