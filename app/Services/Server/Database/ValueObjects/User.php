<?php

namespace App\Services\Server\Database\ValueObjects;

class User
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var array
     */
    protected $grants;

    /**
     * @param string $name
     * @param string $password
     * @param array $grants
     */
    public function __construct(string $name, string $password, array $grants)
    {
        $this->name = $name;
        $this->password = $password;
        $this->grants = $grants;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function getGrants(): array
    {
        return $this->grants;
    }
}