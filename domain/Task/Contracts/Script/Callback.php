<?php

namespace Domain\Task\Contracts\Script;

use App\Models\Server\Task;

interface Callback
{
    /**
     * @param Task $task
     */
    public function handle(Task $task): void;
}