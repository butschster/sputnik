<?php

namespace App\Observers\Server\User;

use App\Models\Server\User;
use App\Utils\SSH\Contracts\KeyGenerator;
use App\Utils\SSH\Contracts\KeyStorage;

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
     * @param User $user
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function creating(User $user): void
    {
        if (!$user->hasKeyPair()) {
            $user->keypair = $this->generator->generate($user->id);
        }
    }

    /**
     * @param User $user
     */
    public function created(User $user): void
    {
        $this->keyStorage->store(
            $user->privateKey()
        );
    }
}
