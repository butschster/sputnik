<?php

namespace App\Utils\SSH;

use App\Utils\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use App\Utils\SSH\Shell\Output;
use App\Utils\SSH\Shell\Response;
use Illuminate\Support\Facades\Log;
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

        try {
            $exitCode = $process->run($output = new Output);
        } catch (ProcessTimedOutException $e) {
            $timedOut = true;
            $exitCode = 1;
        }

        return $this->makeResponse($exitCode, (string)$output, $timedOut);
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
