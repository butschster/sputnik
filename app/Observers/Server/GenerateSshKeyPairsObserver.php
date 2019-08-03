<?php

namespace App\Observers\Server;

use App\Models\Server;
use App\Utils\Ssh\KeyGenerator;

class GenerateSshKeyPairsObserver
{
    /**
     * @var KeyGenerator
     */
    protected $generator;

    /**
     * @param KeyGenerator $generator
     */
    public function __construct(KeyGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param Server $server
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function creating(Server $server)
    {
        if (!$server->hasKeyPair()) {
            $key = $this->generator->generateForServer($server);
            $server->keypair = $key;
        }
    }
}
