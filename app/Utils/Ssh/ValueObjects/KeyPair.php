<?php

namespace App\Utils\Ssh\ValueObjects;

class KeyPair
{
    /**
     * @var string
     */
    protected $public;

    /**
     * @var string
     */
    protected $private;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $public
     * @param string $private
     * @param string $password
     */
    public function __construct(string $public, string $private, string $password)
    {
        $this->public = $public;
        $this->private = $private;
        $this->password = $password;
    }

    /**
     * Get public key
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->public;
    }

    /**
     * Get private key
     *
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->private;
    }

    /**
     * Get key password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
