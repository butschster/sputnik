<?php

namespace Domain\SSH\Services;

use Domain\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use Domain\SSH\Shell\Output;
use Domain\SSH\Shell\Response;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

class ProcessExecutor implements ProcessExecutorContract
{
    /**
     * Run the given script
     *
     * @param Process $process
     *
     * @return Response
     */
    public function run(Process $process): Response
    {
        set_time_limit(0);

        $timedOut = false;

        try {
            $exitCode = $process->run($output = new Output);
        } catch (ProcessTimedOutException $e) {
            $timedOut = true;
            $exitCode = 1;
        }

        return $this->makeResponse($exitCode, (string) $output, $timedOut);
    }

    /**
     * @param int $exitCode
     * @param string $output
     * @param bool $timedOut
     * @return Response
     */
    protected function makeResponse(int $exitCode, string $output, bool $timedOut): Response
    {
        return new Response(
            $exitCode,
            $output,
            $timedOut ?? false
        );
    }
}
