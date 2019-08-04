<?php

namespace Tests\Unit\Services\Task;

use App\Models\Server\Task;
use App\Services\Task\RunnerService;
use App\Utils\Ssh\KeyStorage;
use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\ScriptsStorage;
use App\Utils\Ssh\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Mockery as m;

class RunnerServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_can_be_run()
    {
        $this->mockSshGenerator();

        $this->mock(KeyStorage::class, function ($mock) {
            $mock->shouldReceive('storeKey');
        });

        $this->mock(ScriptsStorage::class, function ($mock) {
            $mock->shouldReceive('storeScript')->once()->andReturn(base_path('tests/fixtures/Ssh/script'));
        });

        $task = factory(Task::class)->create();
        $this->assertEquals(Task::STATUS_PENDING, $task->status);

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
}
