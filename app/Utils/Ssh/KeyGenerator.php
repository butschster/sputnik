<?php

namespace App\Utils\Ssh;

use App\Models\Server;
use App\Utils\Ssh\Shell\SshKeygen;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class KeyGenerator
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var SshKeygen
     */
    protected $command;

    /**
     * @param Filesystem $filesystem
     * @param SshKeygen $command
     */
    public function __construct(Filesystem $filesystem, SshKeygen $command)
    {
        $this->filesystem = $filesystem;
        $this->command = $command;
    }

    /**
     * Generate key-pair for server
     *
     * @param Server $server
     * @return KeyPair
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generateForServer(Server $server): KeyPair
    {
        $name = $server->id;

        // Generate password for key
        $password = Str::random(20);

        $this->command->execute($name, $password);

        [$publicKey, $privateKey] = [
            $this->getKeyContent($name . '.pub'),
            $this->getKeyContent($name),
        ];

        $this->filesystem->delete($this->getKeyPath($name . '.pub'));
        $this->filesystem->delete($this->getKeyPath($name));

        return new KeyPair($publicKey, $privateKey, $password);
    }

    /**
     * @param string $key
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getKeyContent(string $key)
    {
        return $this->filesystem->get($this->getKeyPath($key));
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getKeyPath(string $key)
    {
        return 'tmp/' . $key;
    }
}
