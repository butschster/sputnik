<?php

namespace App\Models\Concerns;

use App\Utils\SSH\ValueObjects\KeyPair;
use App\Utils\SSH\ValueObjects\PrivateKey;
use App\Utils\SSH\ValueObjects\PublicKey;

trait HasKeyPair
{
    /**
     * Set the SSH key attributes on the model from Key pair value object
     *
     * @param KeyPair $keyPair
     * @return void
     */
    public function setKeypairAttribute(KeyPair $keyPair): void
    {
        $this->public_key = $keyPair->getPublicKey();
        $this->private_key = $keyPair->getPrivateKey();
    }

    /**
     * Check if server has key pair
     *
     * @return bool
     */
    public function hasKeyPair(): bool
    {
        return !empty($this->public_key) && !empty($this->private_key);
    }

    /**
     * Get private key
     *
     * @return PrivateKey
     */
    public function privateKey(): PrivateKey
    {
        return new PrivateKey($this->id, $this->private_key);
    }

    /**
     * Get public key
     *
     * @return PublicKey
     */
    public function publicKey(): PublicKey
    {
        return new PublicKey(
            $this->name,
            $this->public_key
        );
    }
}
