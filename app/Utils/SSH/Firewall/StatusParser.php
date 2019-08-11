<?php

namespace App\Utils\SSH\Firewall;

use App\Utils\SSH\ValueObjects\UfwRule;
use Illuminate\Support\Collection;

class StatusParser
{
    const STATUS_ACTIVE = 'active';

    const RULE_REGEX = '/(?<port>\d+|\d+:\d+)(\/(?<protocol>tcp|udp))?\W+(?<version>\(v6\))?\W+(?<policy>ALLOW|DENY)\W+(?<from>Anywhere|(\d+\.\d+\.\d+\.\d+(\/\d+)?))/iu';

    /**
     * @var string
     */
    protected $status;

    /**
     * @param string $status
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Check firewall status
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $matches = null;
        preg_match('#Status: (.+)#', $this->status, $matches);
        $status = $matches ? $matches[1] : null;

        return $status === static::STATUS_ACTIVE;
    }

    /**
     * @return Collection
     */
    public function getRules(): Collection
    {
        $matches = null;
        preg_match_all(static::RULE_REGEX, $this->status, $matches, PREG_SET_ORDER);

        $rules = [];

        foreach ($matches as $rule) {
            $rules[] = new UfwRule(
                $rule['port'], strtolower($rule['policy']), $rule['from'], $rule['protocol'], $rule['version']
            );
        }

        return collect($rules)->filter->isIPv4();
    }
}
