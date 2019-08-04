<?php

namespace App\Utils\Ssh;

use App\Utils\Ssh\Contracts\Script as ScriptContract;

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
     * @var string
     */
    protected $name;

    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    protected $sshAs = self::USER_ROOT;

    /**
     * Get the user that the script should be run as.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->sshAs;
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
