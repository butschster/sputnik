<?php

namespace App\Listeners\Server\Deployment;

use App\Events\Task\Finished;
use App\Events\Task\Running;
use App\Events\Task\Timeout;
use App\Models\Server\Deployment;

class UpdateStatus
{
    /**
     * @param $event
     */
    public function handle($event)
    {
        if ($event instanceof Running && $event->task->owner instanceof Deployment) {
            $event->task->owner->markAsRunning();
        } else if ($event instanceof Finished && $event->task->owner instanceof Deployment) {
            if ($event->task->isSuccessful()) {
                $event->task->owner->markAsFinished();
            } else {
                $event->task->owner->markAsFailed();
            }
        } else if ($event instanceof Timeout && $event->task->owner instanceof Deployment) {
            $event->task->owner->markAsFailed();
        }
    }
}
