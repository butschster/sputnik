<?php

namespace App\Validation\Rules\Server;

use App\Models\Server;
use Illuminate\Contracts\Validation\Rule;

class ModuleInstalled implements Rule
{
    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->server
            ->modules()
            ->where('name', $value)
            ->where('status', Server\Module::STATUS_INSTALLED)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The server module is not installed';
    }
}