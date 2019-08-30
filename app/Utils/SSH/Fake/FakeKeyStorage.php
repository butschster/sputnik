<?php

namespace App\Utils\SSH\Fake;

use App\Utils\SSH\Contracts\KeyStorage as KeyStorageContract;
use App\Utils\SSH\ValueObjects\PrivateKey;

class FakeKeyStorage implements KeyStorageContract
{

    /**
     * Store private key in the key storage
     *
     * @param PrivateKey $key
     * @return string Path to the file
     */
    public function store(PrivateKey $key): string
    {
        return base_path('tests/fixtures/Ssh/id_rsa');
    }

    /**
     * Remove private key from the key storage
     *
     * @param PrivateKey $key
     */
    public function remove(PrivateKey $key): void
    {

    }
}