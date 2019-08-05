<?php

namespace Tests\Unit\Models;

use App\Models\Server;
use App\Models\Server\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_has_server()
    {
        $task = $this->createTask();

        $this->assertInstanceOf(Server::class, $task->server);
    }

    function test_a_task_should_have_pending_status_when_created()
    {
        $task = $this->createTask();

        $this->assertEquals(Task::STATUS_PENDING, $task->status);
    }

    function test_task_can_be_successful()
    {
        $task = $this->makeTask([
            'server_id' => 'uuid',
            'exit_code' => 0,
        ]);

        $this->assertTrue($task->isSuccessful());
    }

    function test_task_can_be_unsuccessful()
    {
        $task = $this->makeTask([
            'server_id' => 'uuid',
            'exit_code' => 1,
        ]);

        $this->assertFalse($task->isSuccessful());
    }

    function test_callbacks_can_be_add()
    {
        $task = $this->createTask();

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

    function test_a_task_can_have_time_out_status()
    {
        $task = $this->createTask();

        $this->assertFalse($task->isTimedOut());
        $task->markAsTimedOut();

        $task->refresh();

        $this->assertEquals(Task::STATUS_TIMEOUT, $task->status);
        $this->assertTrue($task->isTimedOut());
    }

    function test_a_task_can_have_finished_status()
    {
        $task = $this->createTask();

        $this->assertFalse($task->isFinished());
        $task->markAsFinished();

        $task->refresh();

        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
        $this->assertTrue($task->isFinished());
    }

    function test_it_can_have_root_home_directory()
    {
        $task = $this->makeTask([
            'user' => 'root'
        ]);

        $this->assertEquals('/root/.sputnik', $task->path());
    }

    function test_it_can_have_user_home_directory()
    {
        $task = $this->makeTask([
            'user' => 'sputnik'
        ]);

        $this->assertEquals('/home/sputnik/.sputnik', $task->path());
    }

    function test_it_has_script_file_path()
    {
        $task = $this->makeTask([
            'id' => 'uuid',
            'user' => 'root'
        ]);

        $this->assertEquals('/root/.sputnik/uuid.sh', $task->scriptFile());
    }

    function test_it_has_output_file_path()
    {
        $task = $this->makeTask([
            'id' => 'uuid',
            'user' => 'root'
        ]);

        $this->assertEquals('/root/.sputnik/uuid.out', $task->outputFile());
    }

    function test_it_has_server_settings()
    {
        $server = $this->createServer([
            'ip' => '127.0.0.1',
            'ssh_port' => 22,
        ]);

        $task = $this->createTask([
            'server_id' => $server->id
        ]);

        $this->assertEquals('127.0.0.1', $task->serverIpAddress());
        $this->assertEquals(22, $task->serverPort());
//        $this->assertFileExists($path = $task->serverKeyPath());
//
//        @unlink($path);
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
