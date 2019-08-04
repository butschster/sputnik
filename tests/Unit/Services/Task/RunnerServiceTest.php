<?php

namespace Tests\Unit\Services\Task;

use App\Models\Server\Task;
use App\Services\Task\RunnerService;
use App\Utils\Hashids;
use App\Utils\Ssh\KeyStorage;
use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\ScriptsStorage;
use App\Utils\Ssh\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Mockery as m;

class RunnerServiceTest extends TestCase
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

        $processRunner = m::mock(ProcessRunner::class);
        $processRunner->shouldReceive('run')->andReturn(new Response(0, 'success'));

        $service = new RunnerService(
            $processRunner
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

        $processRunner = m::mock(ProcessRunner::class);
        $processRunner->shouldReceive('run')->andReturn(new Response(0, 'success'));

        $service = new RunnerService(
            $processRunner
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
