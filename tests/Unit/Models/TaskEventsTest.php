<?php

namespace Tests\Unit\Models;

use App\Events\Task\Finished;
use App\Events\Task\Response;
use App\Events\Task\Running;
use App\Events\Task\Timeout;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class TaskEventsTest extends TestCase
{
    use DatabaseMigrations;

    function test_when_task_was_sent_in_running_status_event_should_be_fired()
    {
        Event::fake([
            Running::class
        ]);

        $task = $this->createTask();

        $task->markAsRunning();

        Event::assertDispatched(Running::class, function ($event) use($task) {
            return $event->task->is($task);
        });
    }

    function test_when_task_was_sent_in_finished_status_event_should_be_fired()
    {
        Event::fake([
            Finished::class
        ]);

        $task = $this->createTask();

        $task->markAsFinished();

        Event::assertDispatched(Finished::class, function ($event) use($task) {
            return $event->task->is($task);
        });
    }

    function test_when_task_was_sent_in_timeout_status_event_should_be_fired()
    {
        Event::fake([
            Timeout::class
        ]);

        $task = $this->createTask();

        $task->markAsTimedOut();

        Event::assertDispatched(Timeout::class, function ($event) use($task) {
            return $event->task->is($task);
        });
    }

    function test_when_task_receive_response_event_should_be_fired()
    {
        Event::fake([
            Response::class
        ]);

        $task = $this->createTask();

        $task->saveResponse(new \App\Utils\SSH\Shell\Response(0, 'done!'));

        Event::assertDispatched(Response::class, function ($event) use($task) {
            return $event->task->is($task) && $event->response->getOutput() == 'done!';
        });
    }

}
