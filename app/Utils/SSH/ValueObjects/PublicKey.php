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
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * Get key fingerprint
     *
     * @return string
     */
    public function getFingerprint(): string
    {
        $content = explode(' ', $this->getContents(), 3);

        return implode(':', str_split(md5(base64_decode($content[1])), 2));
    }
}
