<?php

namespace App\Utils\Ssh;

use App\Utils\Ssh\Shell\Output;
use App\Utils\Ssh\Shell\Response;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

class ProcessRunner
{
    /**
     * @param Process $process
     *
     * @return Response
     */
    public function run(Process $process): Response
    {
        set_time_limit(0);

        try {
            $exitCode = $process->run($output = new Output);
        } catch (ProcessTimedOutException $e) {
            $timedOut = true;
            $exitCode = 1;
        }

        return new Response(
            $exitCode,
            (string) $output,
            $timedOut ?? false
        );
    }
}
