<?php

namespace App\Models\Server\Firewall;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use Domain\SSH\Bash\Firewall\CommandGenerator;
use Domain\SSH\Contracts\Firewall\UfwRule;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model implements UfwRule
{
    use UsesUuid, HasTask, HasServer;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_firewall_rules';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'from' => null,
        'policy' => 'allow',
        'protocol' => null,
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'editable' => 'bool'
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
     * Generate bash command to enable rule
     *
     * @return string
     * @throws \Exception
     */
    public function toBashEnableCommand(): string
    {
        return (new CommandGenerator())->generateEnableString($this);
    }

    /**
     * Generate bash command to delete rule
     *
     * @return string
     * @throws \Exception
     */
    public function toBashDisableCommand(): string
    {
        return (new CommandGenerator())->generateDisableString($this);
    }
}
