<?php

namespace Domain\Module\Contracts\Entities;

use App\Models\Server;
use Domain\Module\Contracts\Entities\Action\HasSettings;
use Illuminate\Contracts\Support\Arrayable;

interface Action extends HasSettings, Arrayable
{
    /**
     * Get action key
     *
     * @return string
     */
    public function key(): string;

    /**
     * Get module
     *
     * @return Module
     */
    public function getModule(): Module;

    /**
     * Check if action can be run
     *
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Server $server, array $data = []): bool;

    /**
     * Run action script
     *
     * @param Server $server
     * @param array $data
     * @param array $callbacks
     * @return Server\Action
     * @throws \Throwable
     */
    public function run(Server $server, array $data = [], array $callbacks = []): Server\Action;

    /**
     * Render action script
     *
     * @param Server $server
     * @param array $data
     *
     * @return string
     */
    public function render(Server $server, array $data = []): string;
}
