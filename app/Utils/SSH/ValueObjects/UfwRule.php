<?php

namespace App\Utils\SSH\ValueObjects;

use App\Utils\SSH\Contracts\UfwRule as UfwRuleContract;
use App\Utils\SSH\FirewallCommandGenerator;

class UfwRule implements UfwRuleContract
{
    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $policy;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var string|null
     */
    protected $version;

    /**
     * @param string $port
     * @param string $policy
     * @param string|null $from
     * @param string|null $protocol
     * @param string|null $version
     */
    public function __construct(string $port, string $policy = 'allow', string $from = null, string $protocol = null, string $version = null)
    {
        $this->port = $port;
        $this->policy = $policy;
        $this->from = $from == 'Anywhere' ? null : $from;
        $this->protocol = $protocol;
        $this->version = $version == '(v6)' ? 'v6' : 'v4';
    }

    /**
     * Get the policy
     * @return string
     */
    public function policy(): string
    {
        if (empty($this->policy)) {
            return 'allow';
        }

        return $this->policy;
    }

    /**
     * Get the rule protocol
     * @return string|null
     */
    public function protocol(): ?string
    {
        return $this->protocol;
    }

    /**
     * Get the rule port
     * @return string|null
     */
    public function port(): ?string
    {
        if ($this->hasProtocol() && $this->hasPort()) {
            return $this->port . '/' . $this->protocol();
        }

        return $this->port;
    }

    /**
     * Get the from
     * @return string|null
     */
    public function from(): ?string
    {
        return $this->from;
    }

    /**
     * Check if the port was set
     * @return bool
     */
    public function hasFrom(): bool
    {
        return !empty($this->from);
    }

    /**
     * Check if the port was set
     * @return bool
     */
    public function hasPort(): bool
    {
        return !empty($this->port);
    }

    /**
     * Check if the protocol was set
     * @return bool
     */
    public function hasProtocol(): bool
    {
        return !empty($this->protocol);
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @return bool
     */
    public function isIPv4(): bool
    {
        return $this->version == 'v4';
    }

    /**
     * @return bool
     */
    public function isIPv6(): bool
    {
        return $this->version == 'v6';
    }

    /**
     * Generate bash command to enable rule
     * @return string
     * @throws \Exception
     */
    public function toBashEnableCommand(): string
    {
        return (new FirewallCommandGenerator())->generateEnableString($this);
    }

    /**
     * Generate bash command to delete rule
     * @return string
     * @throws \Exception
     */
    public function toBashDisableCommand(): string
    {
        return (new FirewallCommandGenerator())->generateDisableString($this);
    }
}
