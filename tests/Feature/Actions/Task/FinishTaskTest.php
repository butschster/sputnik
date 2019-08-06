<?php

namespace Tests\Feature\Actions\Task;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FinishTaskTest extends TestCase
{
    use DatabaseMigrations;

    // Task ID is required
    function test_task_id_is_required()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'task.finished'])
            ->assertJsonValidationErrors(['task_id']);
    }

    // Task should exist
    function test_task_should_exist()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'task.finished', 'task_id' => 'test'])
            ->assertJsonValidationErrors(['task_id']);
    }

    function test_if_task_is_not_run_then_disable_update_it()
    {
        $task = $this->createTask();

        $this->postJson($this->callbackUrl(), [
            'action' => 'task.finished',
            'task_id' => $task->id,
            'exit_code' => 0,
        ])->assertStatus(404);

        $task->refresh();

        $this->assertTrue($task->isPending());
    }

    function test_a_task_should_be_finished_when_callback_called()
    {
        $task = $this->createTask();

        $task->markAsRunning();

        $this->postJson($this->callbackUrl(), [
            'action' => 'task.finished',
            'task_id' => $task->id,
            'exit_code' => 0,
        ])->assertOk();

        $task->refresh();

        $this->assertTrue($task->isSuccessful());
        $this->assertTrue($task->isFinished());
    }
}
