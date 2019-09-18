<?php

namespace App\Contracts\Server;

use App\Utils\SSH\ValueObjects\PrivateKey;
use App\Utils\SSH\ValueObjects\PublicKey;

interface ServerConfiguration
{
    /**
     * Get server IP address
     *
     * @return string
     */
    public function ip(): string;

    /**
     * Get server SSH port
     *
     * @return int
     */
    public function sshPort(): int;

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
     * Get private key
     *
     * @return PrivateKey
     */
    public function privateKey(): PrivateKey;

    /**
     * Get callback URL, which should be used to send message from remote server
     *
     * @param string $message
     * @return string
     */
    public function callbackUrl(string $message): string;
}
