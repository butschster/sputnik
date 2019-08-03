<?php

namespace App\Utils\Ssh;

class CommandGenerator
{
    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $keyPath;

    /**
     * @var string
     */
    protected $user;

    /**
     * @param string $ipAddress
     * @param int $port
     * @param string $keyPath
     * @param string $user
     */
    public function __construct(string $ipAddress, int $port, string $keyPath, string $user)
    {
        $this->ipAddress = $ipAddress;
        $this->port = $port;
        $this->keyPath = $keyPath;
        $this->user = $user;
    }

    /**
     * Build an SSH command for the given script.
     *
     * @param string $script
     * @return string
     */
    public function forScript(string $script): string
    {
        return sprintf(
            'ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i %s -p %d %s@%s %s',
            $this->keyPath,
            $this->port,
            $this->user,
            $this->ipAddress,
            $script
        );
    }

    /**
     * Build an SSH command for a file upload.
     *
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    public function forUpload(string $from, string $to): string
    {
        return sprintf(
            'scp -i %s -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -o PasswordAuthentication=no -P %s %s %s@%s:%s',
            $this->keyPath,
            $this->port,
            $from,
            $this->user,
            $this->ipAddress,
            $to
        );
    }
}
