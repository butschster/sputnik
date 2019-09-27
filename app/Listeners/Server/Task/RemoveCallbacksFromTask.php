<?php

namespace App\Listeners\Server\Task;

use App\Events\Task\CallbacksHandled;

class RemoveCallbacksFromTask
{
    /**
     * @param CallbacksHandled $event
     */
    public function handle(CallbacksHandled $event): void
    {
        $options = $event->task->options();
        $callbacks = $event->task->callbacks();

        $options['then'] = $callbacks->diff($event->callbacks)->all();
        $event->task->update([
            'options' => $options,
        ]);
    }
}