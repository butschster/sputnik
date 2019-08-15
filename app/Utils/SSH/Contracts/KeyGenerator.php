<?php

namespace App\Utils\SSH\Contracts;

use App\Models\Server;
use App\Utils\SSH\ValueObjects\KeyPair;

interface KeyGenerator
{
    /**
     * Generate key-pair for server
     *
     * @param string $name
     *
     * @return KeyPair
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate(string $name): KeyPair;
}
