<?php

namespace Tests\Unit\Services\Task;

use App\Models\Server\Task;
use Domain\Task\Services\ExecutorService;
use Domain\SSH\Contracts\KeyStorage;
use Domain\SSH\Contracts\ProcessExecutor;
use Domain\SSH\Services\ScriptsStorage;
use Domain\SSH\Shell\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Mockery as m;
use Tests\TestCase;

class ExecutorServiceTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_can_be_run()
    {
        $service = $this->getExecutorService();

        $task = $this->createTask();

        $service->run($task);
        $task->refresh();

        $this->assertEquals('success', $task->output);
        $this->assertEquals(0, $task->exit_code);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
    }

    function test_a_task_can_be_run_in_background()
    {
        $service = $this->getExecutorService();
        $task = $this->createTask();

        $service->runInBackground($task);

        $this->sendCallbackRequest('task.finished', [
            'exit_code' => 1,
            'task_id' => $task->id,
        ])->assertOk();

        $task->refresh();

        $this->assertEquals(1, $task->exit_code);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
    }

    function test_the_task_should_contains_callback_request_in_the_end()
    {
        Carbon::setTestNow('2010-10-10');

        $task = $this->createTask([
            'id' => 'abcd-efgh-ijkl-mnop'
        ]);

        $service = $this->getExecutorService(function($mock) use($task) {
            $mock->shouldReceive('storeScript')->once()->andReturnUsing(function ($script) use($task) {

                $this->assertStringContainsString(
                    'curl -X POST -k -d "task_id=abcd-efgh-ijkl-mnop&exit_code=$STATUS&action=task.finished&expires=1286672400&signature=ab57abdd4ad8deb12b792a0938b5ec7840a32c7c6283ba2e2942d580efa2b611" http://localhost/callback > /dev/null 2>&1',
                    $script
                );

                return '';
            });
        });

        $service->run($task);
    }

    /**
     * @param \Closure|null $scriptsStorageMock
     *
     * @return ExecutorService
     */
    protected function getExecutorService(\Closure $scriptsStorageMock = null): ExecutorService
    {
        $this->mock(KeyStorage::class, function ($mock) {
            $mock->shouldReceive('store');
        });

        $this->mock(ScriptsStorage::class, $scriptsStorageMock ?? function ($mock) {
            $mock->shouldReceive('storeScript')->once()->andReturn(base_path('tests/fixtures/Ssh/script'));
        });

        $executor = m::mock(ProcessExecutor::class);
        $executor->shouldReceive('run')->andReturn(new Response(0, 'success'));

        return new ExecutorService($executor);
    }

}
