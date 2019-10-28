<?php

namespace Domain\Site\ValueObjects;

class Site
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var string
     */
    protected $publicDir;

    /**
     * @var bool
     */
    protected $useSsl;

    /**
     * @var int
     */
    protected $port;

    /**
     * @param Domain $domain
     * @param string $publicDir
     * @param int $port
     * @param bool $useSsl
     */
    public function __construct(Domain $domain, string $publicDir, int $port = 80, bool $useSsl = false)
    {
        $this->domain = $domain;
        $this->publicDir = $publicDir;
        $this->useSsl = $useSsl;
        $this->port = $port;
    }

    /**
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getPublicDir(): string
    {
        return $this->publicDir;
    }

    /**
     * @return bool
     */
    public function isUseSsl(): bool
    {
        return $this->useSsl;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
}