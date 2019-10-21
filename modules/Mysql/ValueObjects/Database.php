<?php

namespace Module\Mysql\ValueObjects;

class Database
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string|null
     */
    protected $characterSet;

    /**
     * @var string|null
     */
    protected $collation;

    /**
     * @var array
     */
    protected $hosts;

    /**
     * @param string $name
     * @param User $user
     * @param array $hosts
     * @param string|null $characterSet
     * @param string|null $collation
     */
    public function __construct(string $name, User $user, array $hosts = ['localhost'], ?string $characterSet = null, ?string $collation = null)
    {
        $this->name = $name;
        $this->user = $user;
        $this->characterSet = $characterSet;
        $this->collation = $collation;
        $this->hosts = $hosts;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getCharacterSet(): ?string
    {
        return $this->characterSet;
    }

    /**
     * @return string|null
     */
    public function getCollation(): ?string
    {
        return $this->collation;
    }

    /**
     * @return array
     */
    public function getHosts(): array
    {
        return $this->hosts;
    }
}