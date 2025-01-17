<?php

namespace Domain\SSH\ValueObjects;

use Domain\SSH\Contracts\Key;

class PublicKey implements Key
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
     * Get path of public key file
     *
     * @return string
     */
    public function getPath(): string
    {
        $path = storage_path('app/keys/' . $this->getName());
        file_put_contents($path, $this->getContents());
        chmod($path, 0600);

        return $path;
    }
}
