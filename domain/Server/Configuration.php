<?php

namespace Domain\Server;

use App\Models\Server;
use Domain\Server\Contracts\Configuration as ConfigurationContract;
use Domain\SSH\ValueObjects\PrivateKey;
use Domain\SSH\ValueObjects\PublicKey;

class Configuration implements ConfigurationContract
{
    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Get server IP address
     * @return string
     */
    public function ip(): string
    {
        return $this->server->ip;
    }

    /**
     * Get server SSH port
     * @return int
     */
    public function sshPort(): int
    {
        return $this->server->ssh_port ?? 22;
    }

    /**
     * Get firewall status
     * @return bool
     */
    public function firewallStatus(): bool
    {
        $status = $this->server->meta['firewall'] ?? 'disabled';

        return $status === 'enabled';
    }

    /**
     * Get public key
     * @return PublicKey
     */
    public function publicKey(): PublicKey
    {
        return new PublicKey($this->server->name, $this->server->public_key);
    }

    /**
     * Get private key
     * @return PrivateKey
     */
    public function privateKey(): PrivateKey
    {
        return new PrivateKey($this->server->id, $this->server->private_key);
    }

    /**
     * Get available system users with root access
     * @return array
     */
    public function systemUsers(): array
    {
        return $this->server->users()->where('is_system', true)->get()->all();
    }

    /**
     * Get callback URL, which should be used to send message from remote server
     *
     * @param string $message
     *
     * @return string
     */
    public function callbackUrl(string $message): string
    {
        return callback_event($this->server->id, $message, 80, 10);
    }

    /**
     * Get the instance as an array.
     * @return array
     */
    public function toArray()
    {
        return [];
    }
}
