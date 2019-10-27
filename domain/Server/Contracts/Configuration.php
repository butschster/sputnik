<?php

namespace Domain\Server\Contracts;

use Domain\SSH\ValueObjects\PrivateKey;
use Domain\SSH\ValueObjects\PublicKey;
use Illuminate\Contracts\Support\Arrayable;

interface Configuration extends Arrayable
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
     * @return bool
     */
    public function firewallStatus(): bool;

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
