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
        if (!$this->task) {
            return false;
        }

        return $this->task->isSuccessful();
    }

    /**
     * @return string
     */
    public function taskStatus(): string
    {
        if (!$this->task) {
            return '';
        }

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
