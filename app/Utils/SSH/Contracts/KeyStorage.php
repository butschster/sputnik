<?php

namespace App\Utils\SSH\Contracts;

use App\Utils\SSH\ValueObjects\PrivateKey;

interface KeyStorage
{
    /**
     * Store private key in the key storage
     *
     * @param PrivateKey $key
     * @return string Path to the file
     */
    public function store(PrivateKey $key): string;

    /**
     * Remove private key from the key storage
     *
     * @param PrivateKey $key
     */
    public function remove(PrivateKey $key): void;
}
