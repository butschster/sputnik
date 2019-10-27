<?php

namespace Tests\Unit\Services\Task;

use App\Models\Server;
use Domain\Task\Factory;
use Domain\SSH\Script;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_task_can_be_created()
    {
        $server = $this->createServer();

        $factory = new Factory();

        $task = $factory->createFromScript($server, $script = new FactoryTestScript(), []);

        $this->assertEquals(1, $server->tasks()->count());
        $this->assertTrue($server->tasks->contains($task));

        $this->assertEquals($script->getName(), $task->name);
        $this->assertEquals($script->getUser(), $task->user);
        $this->assertEquals($script->getScript(), $task->script);
        $this->assertEquals($script->getTimeout(), $task->options['timeout']);
    }

    function test_is_options_contains_timeout_then_it_can_be_used_instead_of_script_timeout()
    {
        $server = $this->createServer();

        $factory = new Factory();

        $task = $factory->createFromScript($server, $script = new FactoryTestScript(), ['timeout' => 30]);

        $this->assertEquals(1, $server->tasks()->count());
        $this->assertTrue($server->tasks->contains($task));

        $this->assertEquals($script->getName(), $task->name);
        $this->assertEquals($script->getUser(), $task->user);
        $this->assertEquals($script->getScript(), $task->script);
        $this->assertEquals(30, $task->options['timeout']);
        $this->assertNotEquals($script->getTimeout(), $task->options['timeout']);
    }
}

class FactoryTestScript extends Script
{
    /**
     * @var string
     */
    protected $name = 'Run phpunit test';

    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    protected $sshAs = 'test';

    /**
     * Get the script string
     *
     * @return string
     */
    public function getScript(): string
    {
        return 'echo "Hello wolrd"';
    }
}
