<?php

namespace App\Models\Server\Firewall;

use App\Models\Concerns\UsesUuid;
use App\Models\Server;
use App\Utils\SSH\FirewallCommandGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    use UsesUuid;

    /**
     * @var string
     */
    protected $table = 'server_firewall';

    /**
     * @var array
     */
    protected $guarded = [];

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
