<?php

namespace App\Utils\SSH\Contracts;

interface KeyStorage
{
    /**
     * Store private key in the key storage
     *
     * @param Key $key
     * @return string Path to the file
     */
    public function store(Key $key): string;

    /**
     * Remove private key from the key storage
     *
     * @param Key $key
     */
    public function remove(Key $key): void;
}
