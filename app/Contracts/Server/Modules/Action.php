<?php

namespace App\Contracts\Server\Modules;

use App\Contracts\Server\Modules\Action\HasForm;
use App\Contracts\Server\Modules\Action\HasSettings;
use App\Models\Server;
use Illuminate\Contracts\Support\Arrayable;

interface Action extends HasForm, HasSettings, Arrayable
{
    /**
     * Get action key
     *
     * @return string
     */
    public function key(): string;

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
     * @return Server\Task
     * @throws \Throwable
     */
    public function run(Server $server, array $data = [], array $callbacks = []): Server\Task;

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