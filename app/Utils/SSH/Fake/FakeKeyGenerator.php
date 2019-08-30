<?php

namespace App\Utils\SSH\Fake;

use App\Utils\SSH\Contracts\KeyGenerator as KeyGeneratorContract;
use App\Utils\SSH\ValueObjects\KeyPair;

class FakeKeyGenerator implements KeyGeneratorContract
{

    /**
     * Generate key-pair for server
     *
     * @param string $name
     *
     * @return KeyPair
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate(string $name): KeyPair
    {
        return new KeyPair(
            file_get_contents(base_path('tests/fixtures/Ssh/id_rsa.pub')),
            file_get_contents(base_path('tests/fixtures/Ssh/id_rsa')),
            ''
        );
    }
}