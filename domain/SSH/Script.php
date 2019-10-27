<?php

namespace Domain\SSH;

use Domain\SSH\Contracts\Script as ScriptContract;

abstract class Script implements ScriptContract
{
    /**
     * The default timeout for tasks.
     *
     * @var int
     */
    const DEFAULT_TIMEOUT = 3600;

    const USER_ROOT = 'root';
    const USER_SPUTNIK = 'sputnik';

    /**
     * The name of the script
     *
     * @var string
     */
    protected $name;

    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    protected $sshAs;

    /**
     * Run script as specified user
     *
     * @param string $user
     */
    public function asUser(string $user): void
    {
        $this->sshAs = $user;
    }

    /**
     * Get the user that the script should be run as.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->sshAs ?? static::USER_ROOT;
    }

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? get_called_class();
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function getTimeout(): ?int
    {
        return static::DEFAULT_TIMEOUT;
    }

    /**
     * Render the script as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getScript();
    }
}
