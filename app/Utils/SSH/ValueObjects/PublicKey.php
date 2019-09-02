<?php

namespace App\Utils\SSH\ValueObjects;

class PublicKey
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $contents;

    /**
     * @param string $name
     * @param string $contents
     */
    public function __construct(string $name, string $contents)
    {
        $this->name = $name;
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get public key content
     *
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * Get key fingerprint of public key
     *
     * @return string
     */
    public function getFingerprint(): string
    {
        $content = explode(' ', $this->getContents(), 3);

        return implode(':', str_split(md5(base64_decode($content[1])), 2));
    }

    /**
     * Compare public keys
     *
     * @param PublicKey $publicKey
     * @return bool
     */
    public function is(PublicKey $publicKey): bool
    {
        return $this->getFingerprint() === $publicKey->getFingerprint();
    }

    /**
     * Get path of private key file
     *
     * @return string
     */
    public function getPath(): string
    {
        return storage_path('app/keys/' . $this->getName());
    }
}
