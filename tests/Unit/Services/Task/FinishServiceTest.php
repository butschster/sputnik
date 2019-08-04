<?php

namespace Tests\Unit\Services\Task;

use App\Models\Server\Task;
use App\Services\Task\FinishService;
use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Mockery as m;

class FinishServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_should_be_finished()
    {
        $task = $this->createTask();

        $processRunner = m::mock(ProcessRunner::class);
        $processRunner->shouldReceive('run')->andReturn(new Response(0, $logs = 'logs output from file'));
        $service = new FinishService(
            $processRunner
        );

        $service->finish($task);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
        $this->assertEquals($logs, $task->output);
        $this->assertEquals(0, $task->exit_code);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
    }

    function test_related_callbacks_should_be_called()
    {
        $task = $this->createTask();

        $task->addCallback($callback = FinishServiceTestCallback::class);

        $processRunner = m::mock(ProcessRunner::class);
        $processRunner->shouldReceive('run')->andReturn(new Response(0, $logs = 'logs output from file'));
        $service = new FinishService(
            $processRunner
        );

        $service->finish($task);

        $this->assertContains($callback, $service->getHandledCallbacks());
    }
}

class FinishServiceTestCallback
{
    public function handle(Task $task){}
}
