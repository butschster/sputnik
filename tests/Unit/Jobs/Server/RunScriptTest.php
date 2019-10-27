<?php

namespace Tests\Unit\Jobs\Server;

use Domain\SSH\Jobs\RunScript;
use Domain\Task\Jobs\Run;
use Domain\SSH\Script;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class RunScriptTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_can_be_dispatch()
    {
        Bus::fake();

        $server = $this->createServer();
        $job = new RunScript($server, $script = new RunScriptTestScript($server->database_password));

        $this->app->call([$job, 'handle']);

        Bus::assertDispatched(Run::class, function (Run $job) use($server) {
            return $job->task->is($server->tasks()->first());
        });
    }

}

class RunScriptTestScript extends Script
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
