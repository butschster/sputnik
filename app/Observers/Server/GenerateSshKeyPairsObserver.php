<?php

namespace App\Observers\Server;

use App\Models\Server;
use Domain\SSH\Contracts\KeyGenerator;
use Domain\SSH\Contracts\KeyStorage;

class GenerateSshKeyPairsObserver
{
    /**
     * @var KeyGenerator
     */
    protected $generator;

    /**
     * @var KeyStorage
     */
    protected $keyStorage;

    /**
     * @param KeyGenerator $generator
     * @param KeyStorage $keyStorage
     */
    public function __construct(KeyGenerator $generator, KeyStorage $keyStorage)
    {
        $this->generator = $generator;
        $this->keyStorage = $keyStorage;
    }

    /**
     * @param Server $server
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function creating(Server $server): void
    {
        if (!$server->hasKeyPair()) {
            $server->keypair = $this->generator->generate($server->id);
        }
    }

    /**
     * @param Server $server
     */
    public function created(Server $server): void
    {
        $this->keyStorage->store(
            $server->privateKey()
        );

        $this->keyStorage->store(
            $server->publicKey()
        );
    }
}
