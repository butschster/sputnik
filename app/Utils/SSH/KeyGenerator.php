<?php

namespace App\Utils\SSH;

use App\Models\Server;
use App\Utils\SSH\Commands\SshKeygen;
use App\Utils\SSH\Contracts\KeyGenerator as KeyGeneratorContract;
use App\Utils\SSH\ValueObjects\KeyPair;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;

class KeyGenerator implements KeyGeneratorContract
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
     * Generate key-pair for the server
     *
     * @param string $name
     * @return KeyPair
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate(string $name): KeyPair
    {
        // Generate password for key
        $password = Str::random(20);

        $this->command->execute($name);

        [$publicKey, $privateKey] = [
            $this->getKeyContent($name . '.pub'),
            $this->getKeyContent($name),
        ];

        $this->filesystem->delete($this->getKeyPath($name . '.pub'));
        $this->filesystem->delete($this->getKeyPath($name));

        return new KeyPair($publicKey, $privateKey, $password);
    }

    /**
     * Load content from the file
     *
     * @param string $key
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getKeyContent(string $key): string
    {
        return $this->filesystem->get($this->getKeyPath($key));
    }

    /**
     * Get the path to generated key
     *
     * @param string $key
     * @return string
     */
    protected function getKeyPath(string $key): string
    {
        return 'tmp/' . $key;
    }
}
