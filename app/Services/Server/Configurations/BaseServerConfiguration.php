<?php

namespace App\Services\Server\Configurations;

use App\Utils\SSH\ValueObjects\PrivateKey;
use App\Utils\SSH\ValueObjects\PublicKey;

trait BaseServerConfiguration
{
    /**
     * Get public key
     *
     * @return PublicKey
     */
    public function publicKey(): PublicKey
    {
        return new PublicKey(
            $this->server->name,
            $this->server->public_key
        );
    }

    /**
     * Get private key
     *
     * @return PrivateKey
     */
    public function privateKey(): PrivateKey
    {
        return new PrivateKey(
            $this->server->id,
            $this->server->private_key
        );
    }

    /**
     * Get available system users with root access
     *
     * @return array
     */
    public function systemUsers(): array
    {
        return $this->server->users()
            ->where('is_system', true)
            ->get()
            ->all();
    }

    /**
     * Get callback URL, which should be used to send message from remote server
     *
     * @param string $message
     * @return string
     */
    public function callbackUrl(string $message): string
    {
        return callback_event($this->server->id, $message, 80, 10);
    }
}