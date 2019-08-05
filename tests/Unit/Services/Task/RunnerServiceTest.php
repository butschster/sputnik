<?php

namespace Tests\Unit\Services\Task;

use App\Models\Server\Task;
use App\Services\Task\ExecutorService;
use App\Utils\SSH\Contracts\KeyStorage;
use App\Utils\SSH\Contracts\ProcessExecutor;
use App\Utils\SSH\ScriptsStorage;
use App\Utils\SSH\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Mockery as m;

class ExecutorServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_can_be_run()
    {
        $this->mock(KeyStorage::class, function ($mock) {
            $mock->shouldReceive('storeKey');
        });

        $this->mock(ScriptsStorage::class, function ($mock) {
            $mock->shouldReceive('storeScript')->once()->andReturn(base_path('tests/fixtures/Ssh/script'));
        });

        $task = $this->createTask();

        $executor = m::mock(ProcessExecutor::class);
        $executor->shouldReceive('run')->andReturn(new Response(0, 'success'));

        $service = new ExecutorService(
            $executor
        );

        $service->run($task);
        $task->refresh();

        $this->assertEquals('success', $task->output);
        $this->assertEquals(0, $task->exit_code);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
    }

    function test_a_task_can_be_run_in_background()
    {
        $this->mock(KeyStorage::class, function ($mock) {
            $mock->shouldReceive('storeKey');
        });

        $this->mock(ScriptsStorage::class, function ($mock) {
            $mock->shouldReceive('storeScript')->once()->andReturn(base_path('tests/fixtures/Ssh/script'));
        });

        $task = $this->createTask();

        $executor = m::mock(ProcessExecutor::class);
        $executor->shouldReceive('run')->andReturn(new Response(0, 'success'));

        $service = new ExecutorService(
            $executor
        );

        $service->runInBackground($task);

        $response = $this->post(route('server.task.callback', $task), [
            'exit_code' => 1
        ]);

        $response->assertOk();

        $task->refresh();

        $this->assertEquals(1, $task->exit_code);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
    }
}
