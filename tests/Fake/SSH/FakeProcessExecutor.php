<?php

namespace Tests\Fake\SSH;

use Domain\SSH\Services\ProcessExecutor;
use Domain\SSH\Shell\Response;
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