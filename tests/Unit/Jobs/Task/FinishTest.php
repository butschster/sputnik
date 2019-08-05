<?php

namespace Tests\Unit\Jobs\Task;

use App\Jobs\Task\Finish;
use App\Models\Server\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FinishTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_can_finish_a_task()
    {
        $task = $this->createTask();

        $this->assertFalse($task->isFinished());
        dispatch(new Finish($task, 1));

        $task->refresh();

        $this->assertTrue($task->isFinished());
        $this->assertEquals(1, $task->exit_code);
        $this->assertEquals('done!', $task->output);
    }
}
