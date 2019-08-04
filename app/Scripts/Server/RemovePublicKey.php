<?php

namespace App\Scripts\Server;

use App\Utils\Ssh\Script;

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
     * The user that the script should be run as.
     *
     * @var string
     */
    public $sshAs = self::USER_SPUTNIK;

    /**
     * Create a new script instance.
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
        return "Remove SSH Key";
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
