<?php

namespace App\Utils\SSH\ValueObjects;

class SystemInformation
{
    /**
     * @var string
     */
    protected $os;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $architecture;

    /**
     * @param string $os
     * @param string $version
     * @param string $architecture
     */
    public function __construct(string $os, string $version, string $architecture)
    {
        $this->os = $os;
        $this->version = $version;
        $this->architecture = $architecture;
    }

    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getArchitecture(): string
    {
        return $this->architecture;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return sprintf(
            '%s v.%s [%s bits]',
            $this->getOs(), $this->getVersion(), $this->getArchitecture()
        );
    }

    /**
     * @return bool
     */
    public function isSupported(): bool
    {
        return $this->getArchitecture() == '64'
            && in_array($this->version, config('configurations.os.'.strtolower($this->os), []));
    }

}
