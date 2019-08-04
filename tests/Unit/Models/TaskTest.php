<?php

namespace Tests\Unit\Models;

use App\Models\Server\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    function test_task_can_be_successful()
    {
        $task = factory(Task::class)->make([
            'server_id' => 'uuid',
            'exit_code' => 0
        ]);

        $this->assertTrue($task->isSuccessful());
    }

    function test_task_can_be_unsuccessful()
    {
        $task = factory(Task::class)->make([
            'server_id' => 'uuid',
            'exit_code' => 1
        ]);

        $this->assertFalse($task->isSuccessful());
    }

    function test_callbacks_can_be_add()
    {
        $this->mockSshGenerator();

        $task = factory(Task::class)->create();

        $this->assertCount(0, $task->callbacks());

        $task->addCallback($callback = TaskTestCallback::class);

        $task->refresh();
        $this->assertTrue(
            $task->callbacks()->contains($callback)
        );
        $this->assertCount(1, $task->callbacks());

        $task->addCallback($callback1 = new TaskTestDispatchCallback($callback));

        $task->refresh();
        $this->assertTrue(
            $task->callbacks()->contains($callback1)
        );

        $this->assertCount(2, $task->callbacks());
    }
}

class TaskTestCallback
{

}

class TaskTestDispatchCallback
{
    /**
     * The job that should be dispatched.
     *
     * @var string
     */
    public $class;

    /**
     * Create a new callback instance.
     *
     * @param string $class
     * @return void
     */
    public function __construct($class)
    {
        $this->class = $class;
    }
}
