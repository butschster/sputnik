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

        Log::info($process->getCommandLine());

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
