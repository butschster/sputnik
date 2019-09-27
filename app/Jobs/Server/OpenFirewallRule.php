<?php

namespace App\Jobs\Server;

use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OpenFirewallRule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $port;

    /**
     * @var string
     */
    public $policy;

    /**
     * @var bool
     */
    public $editable;

    /**
     * @var Server
     */
    public $server;

    /**
     * @param Server $server
     * @param string $name
     * @param int $port
     * @param string $policy
     * @param bool $editable
     */
    public function __construct(Server $server, string $name, int $port, string $policy = 'allow', bool $editable = true)
    {
        $this->name = $name;
        $this->port = $port;
        $this->policy = $policy;
        $this->editable = $editable;
        $this->server = $server;
    }

    public function handle()
    {
        $this->server->firewallRules()->firstOrCreate([
            'port' => $this->port,
            'policy' => $this->policy,
        ],[
            'name' => $this->name,
            'editable' => $this->editable,
        ]);
    }
}
