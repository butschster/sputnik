<?php

namespace Domain\Site\ValueObjects;

class Domain
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $aliases;

    /**
     * @param string $name
     * @param array $aliases
     */
    public function __construct(string $name, array $aliases = [])
    {
        $this->name = $name;
        $this->aliases = $aliases;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }
}