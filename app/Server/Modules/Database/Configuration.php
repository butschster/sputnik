<?php

namespace App\Server\Modules\Database;

use App\Models\Server;
use App\Server\Modules\Configuration as BaseConfiguration;
use App\Services\Server\Database\ValueObjects\User;
use Illuminate\Support\Str;

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
     * Install module
     *
     * @param Server $server
     * @param array $data
     *
     * @return array
     * @throws \Throwable
     */
    public function install(Server $server, array $data): array
    {
        $data['password'] = Str::random(10);
        $data['databaseUsers'] = $this->getDatabaseUsers($server, $data['password']);
        $data['hosts'] = [$server->ip, 'localhost'];

        $script = $this->render($server, 'database.'.$this->type().'.install', $data);

        $this->runScript(
            $server,
            $script,
            sprintf('Install %s', $this->module->title())
        );

        return $data;
    }

    /**
     * Uninstall module
     *
     * @param Server $server
     *
     * @throws \Throwable
     */
    public function uninstall(Server $server): void
    {
        $script = $this->render($server, 'database.'.$this->type().'.uninstall');

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
     * @param string $password
     * @return \Illuminate\Support\Collection
     */
    protected function getDatabaseUsers(Server $server, string $password): \Illuminate\Support\Collection
    {
        return collect($server->toConfiguration()->systemUsers())
            ->map(function ($user) use($server, $password) {
                return new User($user->name, $password, ['*.*']);
            });
    }
}