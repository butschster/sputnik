<?php

namespace Domain\SSH\Bash;

class CommandGenerator
{
    /**
     * The server ap address
     *
     * @var string
     */
    protected $ipAddress;

    /**
     * The server post
     *
     * @var int
     */
    protected $port;

    /**
     * The private key path on local server
     *
     * @var string
     */
    protected $keyPath;

    /**
     * SSH user
     *
     * @var string
     */
    protected $user;

    /**
     * Generate SSH commands for connect to remote server
     *
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
     * @param string|array $script
     * @return array
     */
    public function forScript($script): array
    {
        $command = [
            'ssh',
            '-o', 'UserKnownHostsFile=/dev/null',
            '-o', 'StrictHostKeyChecking=no',
            '-i', $this->keyPath,
            '-p', $this->port,
            $this->user.'@'.$this->ipAddress,
        ];

        if (is_array($script)) {
            return array_merge($command, $script);
        }

        $command[] = $script;

        return $command;
    }

    /**
     * Build an SSH command for a file upload.
     *
     * @param string $from
     * @param string $to
     *
     * @return array
     */
    public function forUpload(string $from, string $to): array
    {
        return [
            'scp',
            '-i', $this->keyPath,
            '-o', 'UserKnownHostsFile=/dev/null',
            '-o', 'StrictHostKeyChecking=no',
            '-o', 'PasswordAuthentication=no',
            '-P', $this->port,
            $from,
            $this->user.'@'.$this->ipAddress.':'.$to,
        ];
    }
}
