<?php

namespace App\Utils\SSH\Contracts;

use App\Utils\SSH\ValueObjects\PrivateKey;

interface KeyStorage
{
    /**
     * @param PrivateKey $key
     *
     * @return string Path to the file
     */
    public function storeKey(PrivateKey $key): string;
}
