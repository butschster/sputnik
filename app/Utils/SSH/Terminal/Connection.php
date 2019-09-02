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
     * @var resource
     */
    protected $sshConnection;

    /**
     * Check if connection is open
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isOpen;
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
        $this->closeSshConnection();
    }

    /**
     * Check connection to ssh
     *
     * @return bool
     */
    public function isConnectedToSsh(): bool
    {
        return $this->sshConnection !== null;
    }

    /**
     * @param $connection
     * @return Connection
     */
    public function setSshConnection($connection)
    {
        $this->sshConnection = $connection;

        return $this;
    }

    /**
     * Set ssh connection
     *
     * @param resource $shell
     * @return Connection
     */
    public function setSshShell($shell)
    {
        $this->shell = $shell;

        return $this;
    }

    /**
     * @param ConnectionInterface $from
     * @param string $command
     * @return $this|void
     */
    public function runScript(ConnectionInterface $from, string $command)
    {
        fwrite($this->shell, $command);
        usleep(800);
        $this->listenSSH($from);

        return $this;
    }

    /**
     * @param ConnectionInterface $from
     */
    public function listenSSH(ConnectionInterface $from): void
    {
        while ($this->isConnectedToSsh() && $line = fgets($this->shell) ) {
            $from->send(mb_convert_encoding($line, "UTF-8"));
        }
    }

    public function closeSshConnection()
    {
        if ($this->sshConnection) {
            ssh2_disconnect($this->sshConnection);

            unset($this->sshConnection);
            unset($this->shell);
        }
    }
}
