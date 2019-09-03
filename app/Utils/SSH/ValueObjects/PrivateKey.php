<?php

namespace App\Utils\SSH\ValueObjects;

use App\Utils\SSH\Contracts\Key;

class PrivateKey implements Key
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
        $path = storage_path('app/keys/' . $this->getName());
        file_put_contents($path, $this->getContents());
        chmod($path, 0600);

        return $path;
    }
}
