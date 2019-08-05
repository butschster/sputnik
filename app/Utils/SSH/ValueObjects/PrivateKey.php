<?php

namespace App\Utils\SSH\ValueObjects;

class PrivateKey
{
    /**
     * The name of the key
     *
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
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
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
