<?php

namespace App\Scripts\Server;

use App\Utils\SSH\Script;

class RemovePublicKey extends Script
{
    /**
     * The public SSH key name.
     *
     * @var string
     */
    protected $name;

    /**
     * The public SSH key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new script instance.
     * Remove public ket from remove server
     *
     * @param string $name
     * @return void
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Remove SSH Key [{$this->name}]";
    }

    /**
     * @return int|null
     */
    public function getTimeout(): ?int
    {
        return 10;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return view('scripts.server.removeKey', [
            'name' => $this->name,
        ])->render();
    }
}
