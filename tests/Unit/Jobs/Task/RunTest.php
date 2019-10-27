<?php

namespace Tests\Unit\Jobs\Task;

use Domain\SSH\Jobs\RunScript;
use App\Models\Server\Task;
use Domain\SSH\Script;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RunTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_can_be_dispatch()
    {
        $server = $this->createServer();

        dispatch(
            new RunScript($server, $script = new \Tests\Unit\Jobs\Task\RunTestFakeScript($server->database_password))
        );

        $this->assertCount(1, $server->tasks);

        $task =  $server->tasks()->first();

        $this->assertEquals(get_class($script), $task->name);
        $this->assertEquals(Task::STATUS_FINISHED, $task->status);
        $this->assertEquals($script->getScript(), $task->script);
    }

}

class RunTestFakeScript extends Script
{
    /**
     * @var string
     */
    public $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function getScript(): string
    {
        return "GRANT ALL ON homestead.* to 'homestead'@'localhost' IDENTIFIED BY '{$this->password}}';";
    }
}
