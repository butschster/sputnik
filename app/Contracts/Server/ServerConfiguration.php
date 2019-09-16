<?php

namespace App\Contracts\Server;

use App\Utils\SSH\ValueObjects\PublicKey;

interface ServerConfiguration
{
    /**
     * Get available system users with root access
     *
     * @return array
     */
    public function systemUsers(): array;

    /**
     * Get public key
     *
     * @return PublicKey
     */
    public function publicKey(): PublicKey;

    /**
     * Get callback URL, which should be used to send message from remote server
     *
     * @param string $message
     * @return string
     */
    public function callbackUrl(string $message): string;
}
