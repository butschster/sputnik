<?php

namespace App\Listeners\Server\Task;

use App\Events\Task\Timeout;

class CheckConnectionProblems
{
    /**
     * @param Timeout $event
     */
    public function handle(Timeout $event)
    {
        throw new \RuntimeException($event->task->output);
    }
}