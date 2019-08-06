<?php

namespace App\Scripts\Server\Firewall;

use App\Models\Server\Firewall;
use App\Utils\SSH\Script;

class EnableRule extends Script
{
    /**
     * @var Firewall
     */
    protected $rule;

    /**
     * @param Firewall $rule
     */
    public function __construct(Firewall $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function getName(): string
    {
        return "Enable UFW rule";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('scripts.server.firewall.enable_rule', [
            'rule' => $this->rule,
        ])->render();
    }
}
