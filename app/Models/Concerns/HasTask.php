<?php

namespace App\Models\Concerns;

use App\Models\Server\Task;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
            return Task::STATUS_PENDING;
        }

        return $this->task->status;
    }

    /**
     * @return MorphOne
     */
    public function task(): MorphOne
    {
        return $this->morphOne(Task::class, 'owner');
    }
}
