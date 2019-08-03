<?php

namespace App\Utils\Ssh\Shell;

use Symfony\Component\Process\Process;

class SshKeygen
{
    /**
     * @param string $name
     * @param string $password
     * @return int
     */
    public function execute(string $name, string $password)
    {
        $process = new Process(
            sprintf('ssh-keygen -C "robot@laravel.com" -f %s -t rsa -b 4096 -N %s', $name, escapeshellarg($password)),
            storage_path('app/tmp')
        );

        return $process->run();
    }
}
