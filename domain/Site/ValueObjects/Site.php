<?php

namespace Domain\Site\ValueObjects;

class Site
{
    /**
     * @param \App\Models\Server\Site $site
     * @return static
     */
    public static function fromModel(\App\Models\Server\Site $site)
    {
        return new static(
            new Domain(
                $site->domain, $site->aliases
            ),
            $site->path(),
            $site->publicPath(),
            80,
            $site->use_ssl,
            $site->proxy_address
        );
    }

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var string
     */
    protected $dir;

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
     * @var string|null
     */
    protected $proxyAddress;

    /**
     * @param Domain $domain
     * @param string $dir
     * @param string $publicDir
     * @param int $port
     * @param bool $useSsl
     * @param string|null $proxyAddress
     */
    public function __construct(Domain $domain, string $dir, string $publicDir, int $port = 80, bool $useSsl = false, ?string $proxyAddress = null)
    {
        $this->domain = $domain;
        $this->publicDir = $publicDir;
        $this->useSsl = $useSsl;
        $this->port = $port;
        $this->proxyAddress = $proxyAddress;
        $this->dir = $dir;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain->getDomain();
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
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

    /**
     * @return string|null
     */
    public function getProxyAddress(): ?string
    {
        return $this->proxyAddress;
    }
}