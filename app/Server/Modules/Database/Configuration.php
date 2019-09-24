<?php

namespace App\Server\Modules\Database;

use App\Models\Server;
use App\Server\Modules\Configuration as BaseConfiguration;
use App\Services\Server\Database\ValueObjects\User;

class Configuration extends BaseConfiguration
{
    /**
     * Get database type
     *
     *
     * @return string
     */
    public function type(): string
    {
        return $this->module->key();
    }

    /**
     * Additional data for render
     *
     * @param Server $server
     *
     * @return array
     */
    protected function data(Server $server): array
    {
        return [
            'password' => $this->getDatabasePassword($server),
            'hosts' =>  [$server->ip, 'localhost'],
            'databaseUsers' => $this->getDatabaseUsers($server)
        ];
    }

    /**
     * Install module
     *
     * @param Server $server
     * @param array $data
     *
     * @throws \Throwable
     */
    public function install(Server $server, array $data): void
    {
        $script = $this->render($server, 'database.'.$this->type().'.install', $data);

        $this->runScript(
            $server,
            $script,
            sprintf('Install %s', $this->module->title())
        );
    }

    /**
     * Uninstall module
     *
     * @param Server $server
     * @param array $data
     *
     * @throws \Throwable
     */
    public function uninstall(Server $server, array $data): void
    {
        $script = $this->render($server, 'database.'.$this->type().'.uninstall', $data);

        $this->runScript(
            $server,
            $script,
            sprintf('Uninstall %s', $this->module->title())
        );
    }

    /**
     * Restart module
     *
     * @param Server $server
     *
     * @throws \Throwable
     */
    public function restart(Server $server): void
    {
        $script = $this->render($server, 'database.'.$this->type().'.restart');

        $this->runScript(
            $server,
            $script,
            sprintf('Restart %s', $this->module->title())
        );
    }

    /**
     * @param Server $server
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getDatabaseUsers(Server $server): \Illuminate\Support\Collection
    {
        return collect($server->toConfiguration()->systemUsers())
            ->map(function ($user) use($server) {
                return new User($user->name, $this->getDatabasePassword($server), ['*.*']);
            });
    }

    /**
     * @param Server $server
     *
     * @return string|null
     */
    protected function getDatabasePassword(Server $server): ?string
    {
        return $server->meta('database_password');
    }
}
