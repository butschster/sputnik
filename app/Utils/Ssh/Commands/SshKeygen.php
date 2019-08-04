<?php

namespace App\Utils\Ssh\Commands;

use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\Shell\Response;
use Symfony\Component\Process\Process;

class SshKeygen
{
    /**
     * @var ProcessRunner
     */
    protected $processRunner;

    /**
     * @param ProcessRunner $processRunner
     */
    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    /**
     * Generate key pair
     *
     * @param string $name
     * @param string $password
     *
     * @return Response
     */
    public function execute(string $name, string $password): Response
    {
        $process = new Process(
            sprintf('ssh-keygen -C "robot@laravel.com" -f %s -t rsa -b 4096 -N %s', $name, escapeshellarg($password)),
            storage_path('app/tmp')
        );

        return $this->processRunner->run(
            $process
        );
    }
}
