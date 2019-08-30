<?php

namespace App\Utils\SSH\Fake;

use App\Utils\SSH\ProcessExecutor;
use App\Utils\SSH\Shell\Response;
use Symfony\Component\Process\Process;

class FakeProcessExecutor extends ProcessExecutor
{
    /**
     * @param Process $process
     * @return string
     */
    protected function getOutput(Process $process): string
    {
        return '';
    }

    /**
     * Run the given script
     *
     * @param Process $process
     *
     * @return Response
     */
    public function run(Process $process): Response
    {
        return $this->makeResponse(0, $this->getOutput($process), false);
    }
}