<?php

namespace App\Utils\SSH\Terminal;

use Ratchet\ConnectionInterface;

class Connection
{
    /**
     * @var bool
     */
    protected $isOpen = false;

    /**
     * @var resource
     */
    protected $shell;

    /**
     * Check if connection is open
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isOpen();
    }

    /**
     * Close current connection
     */
    public function open(): void
    {
        $this->isOpen = true;
    }

    /**
     * Close current connection
     */
    public function close(): void
    {
        $this->isOpen = false;
    }

    /**
     * Check connection to ssh
     *
     * @return bool
     */
    public function isConnectedToSsh(): bool
    {
        return (bool) $this->shell;
    }

    /**
     * Set ssh connection
     *
     * @param resource $shell
     */
    public function setSshShell($shell): void
    {
        $this->shell = $shell;
    }

    /**
     * @param ConnectionInterface $from
     * @param string $command
     */
    public function runScript(ConnectionInterface $from, string $command)
    {
        if (!$this->isConnectedToSsh()) {
            return;
        }

        fwrite($this->shell, $command);

        usleep(800);

        $this->listenSSH($from);
    }

    /**
     * @param ConnectionInterface $from
     */
    public function listenSSH(ConnectionInterface $from): void
    {
        if (!$this->isConnectedToSsh()) {
            return;
        }

        while ($line = fgets($this->shell)) {
            $from->send(mb_convert_encoding($line, "UTF-8"));
        }
    }
}
