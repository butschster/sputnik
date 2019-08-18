<?php

namespace App\Scripts\Server;

use App\Utils\SSH\Script;

class CustomScript extends Script
{
    /**
     * @var string
     */
    protected $script;

    /**
     * @param string $name
     * @param string $script
     */
    public function __construct(string $name, string $script)
    {
        $this->name = $name;
        $this->script = $script;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return $this->script;
    }
}