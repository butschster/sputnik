<?php

namespace App\Scripts\Server\Firewall;

use App\Models\Server\Firewall\Rule;
use App\Utils\SSH\Script;

class EnableRule extends Script
{
    /**
     * @var Rule
     */
    protected $rule;

    /**
     * @param Rule $rule
     */
    public function __construct(Rule $rule)
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
        return "Enable UFW rule [{$this->rule->name}]";
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
