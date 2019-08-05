<?php

namespace App\Utils\SSH\Contracts;

use App\Utils\SSH\Shell\Response;
use Symfony\Component\Process\Process;

interface ProcessExecutor
{
    /**
     * @param Process $process
     *
     * @return Response
     */
    public function run(Process $process): Response;
}
