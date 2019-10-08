<?php

namespace App\Contracts\Server;

use App\Contracts\Server\Modules\Action;
use App\Models\Server;
use Illuminate\Contracts\Support\Arrayable;

interface Module extends Arrayable
{
    /**
     * Get module categories
     * @return array
     */
    public function categories(): array;

    /**
     * Get module title
     * @return string
     */
    public function title(): string;

    /**
     * Get module key
     * @return string
     */
    public function key(): string;

    /**
     * Get module meta
     *
     * @return array
     */
    public function meta(): array;

    /**
     * Get module dependencies
     * @return array
     */
    public function dependencies(): array;

    /**
     * Get module conflicts
     *
     * @return array
     */
    public function conflicts(): array;

    /**
     * Get list of actions
     *
     * @return array
     */
    public function actions(): array;

    /**
     * Get action by name
     *
     * @param string $name
     * @return Action
     */
    public function getAction(string $name): Action;

    /**
     * Check if action exists
     *
     * @param string $name
     * @return bool
     */
    public function hasAction(string $name): bool;

    /**
     * Run action on a specified Server
     *
     * @param string $name
     * @param Server $server
     * @param array $data
     * @return Server\Task
     */
    public function runAction(string $name, Server $server, array $data = []): Server\Task;
}
