<?php

namespace Tests\Unit\Utils\Ssh;

use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\Shell\Output;
use Mockery as m;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class ProcessRunnerTest extends TestCase
{
    function test_in_can_be_run()
    {
        $process = m::mock(Process::class);

        $process->shouldReceive('run')->once()->andReturnUsing(function (Output $output) {
            $output('test', 'Hello world');
            $output('test1', 'Hello world');

            return 0;
        });

        $processRunner = new ProcessRunner();

        $response = $processRunner->run($process);

        $this->assertEquals('Hello worldHello world', $response->getOutput());
        $this->assertEquals(0, $response->getExitCode());
        $this->assertFalse($response->isTimedOut());
    }

    function test_process_can_throw_time_out_exception()
    {
        $process = m::mock(Process::class);

        $process->shouldReceive('run')->once()->andReturnUsing(function (Output $output) use($process) {
            throw new ProcessTimedOutException($process, 1);
        });

        $process->shouldReceive('getCommandLine')->once()->andReturn('echo "Hello wolrd"');
        $process->shouldReceive('getTimeout')->once()->andReturn(60);

        $processRunner = new ProcessRunner();

        $response = $processRunner->run($process);

        $this->assertEquals('', $response->getOutput());
        $this->assertEquals(1, $response->getExitCode());
        $this->assertTrue($response->isTimedOut());
    }
}
