<?php

namespace App\Utils\SSH\Fake;

use App\Utils\SSH\Contracts\Key;
use App\Utils\SSH\Contracts\KeyStorage as KeyStorageContract;

class FakeKeyStorage implements KeyStorageContract
{

    /**
     * Store private key in the key storage
     *
     * @param Key $key
     * @return string Path to the file
     */
    public function store(Key $key): string
    {
        return base_path('tests/fixtures/Ssh/id_rsa');
    }

    /**
     * Remove private key from the key storage
     *
     * @param Key $key
     */
    public function remove(Key $key): void
    {

    }
}