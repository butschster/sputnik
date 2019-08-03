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
        try {
            $process = $process->run($output = new Output);
        } catch (ProcessTimedOutException $e) {
            $timedOut = true;
        }

        return new Response(
            $process->getExitCode(),
            (string) $output,
            $timedOut ?? false
        );
    }
}
