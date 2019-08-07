<?php

namespace App\Models\Concerns;

use App\Models\Server\Task;

trait HasTask
{
    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->task->isSuccessful();
    }

    /**
     * @return string
     */
    public function taskStatus(): string
    {
        return $this->task->status;
    }

    /**
     * @return mixed
     */
    public function task()
    {
        return $this->morphOne(Task::class, 'owner');
    }
}
