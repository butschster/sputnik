<?php

namespace Tests\Feature\Task;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CallbackTest extends TestCase
{
    use DatabaseMigrations;

    function test_if_task_is_not_run_then_disable_update_id()
    {
        $task = $this->createTask();

        $this->postJson(route('server.task.callback', $task), [
            'exit_code' => 0,
        ])->assertStatus(404);

        $task->refresh();

        $this->assertTrue($task->isPending());
    }

    function test_a_task_should_be_finished_when_callback_called()
    {
        $task = $this->createTask();

        $task->markAsRunning();

        $this->postJson(route('server.task.callback', $task), [
            'exit_code' => 0,
        ])->assertOk();

        $task->refresh();

        $this->assertTrue($task->isSuccessful());
        $this->assertTrue($task->isFinished());
    }
}
