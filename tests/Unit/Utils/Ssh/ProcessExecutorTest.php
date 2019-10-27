<?php

namespace Tests\Unit\Utils\SSH;

use Domain\SSH\Services\ProcessExecutor;
use Domain\SSH\Shell\Output;
use Mockery as m;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class ProcessExecutorTest extends TestCase
{
    function test_in_can_be_run()
    {
        $process = m::mock(Process::class);

        $process->shouldReceive('run')->once()->andReturnUsing(function (Output $output) {
            $output('test', 'Hello world');
            $output('test1', 'Hello world');

            return 0;
        });

        $executor = new ProcessExecutor();

        $response = $executor->run($process);

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

        $process->shouldReceive('getCommandLine')->once()->andReturn('echo "Hello world"');
        $process->shouldReceive('getTimeout')->once()->andReturn(60);

        $executor = new ProcessExecutor();

        $response = $executor->run($process);

        $this->assertEquals('', $response->getOutput());
        $this->assertEquals(1, $response->getExitCode());
        $this->assertTrue($response->isTimedOut());
    }
}
