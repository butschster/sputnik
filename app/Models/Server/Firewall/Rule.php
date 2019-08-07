<?php

namespace App\Models\Server\Firewall;

use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\Server;
use App\Utils\SSH\Contracts\UfwRule;
use App\Utils\SSH\FirewallCommandGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model implements UfwRule
{
    use UsesUuid, HasTask;

    /**
     * @var string
     */
    protected $table = 'server_firewall_rules';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $attributes = [
        'from' => null,
        'policy' => 'allow',
        'protocol' => null,
    ];

    /**
     * Get the policy
     *
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
     *
     * @return string|null
     */
    public function protocol(): ?string
    {
        return $this->protocol;
    }

    /**
     * Get the rule port
     *
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
     *
     * @return string|null
     */
    public function from(): ?string
    {
        return $this->from;
    }

    /**
     * Check if the port was set
     *
     * @return bool
     */
    public function hasFrom(): bool
    {
        return !empty($this->from);
    }

    /**
     * Check if the port was set
     *
     * @return bool
     */
    public function hasPort(): bool
    {
        return !empty($this->port);
    }

    /**
     * Check if the protocol was set
     *
     * @return bool
     */
    public function hasProtocol(): bool
    {
        return !empty($this->protocol);
    }

    /**
     * Get the server that belong to the firewall rule.
     *
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Generate bash command to enable rule
     *
     * @return string
     * @throws \Exception
     */
    public function toBashEnableCommand(): string
    {
        return (new FirewallCommandGenerator())->generateEnableString($this);
    }

    /**
     * Generate bash command to delete rule
     *
     * @return string
     * @throws \Exception
     */
    public function toBashDisableCommand(): string
    {
        return (new FirewallCommandGenerator())->generateDisableString($this);
    }
}
