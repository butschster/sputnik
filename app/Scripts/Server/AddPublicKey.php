<?php

namespace App\Scripts\Server;

use App\Utils\SSH\Script;

class AddPublicKey extends Script
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
     * The user that the script should be run as.
     *
     * @var string
     */
    protected $sshAs = self::USER_SPUTNIK;

    /**
     * Create a new script instance.
     * Upload public key to remove server
     *
     * @param string $name
     * @param string $key
     * @return void
     */
    public function __construct(string $name, string $key)
    {
        $this->key = $key;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Add SSH Key [{$this->name}]";
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
        return view('scripts.server.addKey', [
            'name' => $this->name,
            'key' => $this->key,
        ])->render();
    }
}
