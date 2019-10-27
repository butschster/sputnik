<?php

namespace Domain\SSH\Bash;

use Domain\SSH\Contracts\ProcessExecutor;
use Domain\SSH\Shell\Response;
use Symfony\Component\Process\Process;

class SshKeygen
{
    /**
     * @var ProcessExecutor
     */
    protected $executor;

    /**
     * @param ProcessExecutor $executor
     */
    public function __construct(ProcessExecutor $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Generate key pair
     *
     * @param string $name
     * @param string $password
     *
     * @return Response
     */
    public function execute(string $name, string $password = null): Response
    {
        $process = new Process(
            sprintf('ssh-keygen -C "sputnik@superprojects.space" -f %s -t rsa -b 4096 -N %s', $name, escapeshellarg($password)),
            storage_path('app/tmp')
        );

        return $this->executor->run(
            $process
        );
    }
}
