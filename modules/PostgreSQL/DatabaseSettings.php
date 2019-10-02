<?php

namespace Module\PostgreSQL;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Models\Server;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Module\Mysql\ValueObjects\User;

class DatabaseSettings implements Extension
{
    /**
     * Check if action can be run
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return true;
    }

    /**
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function data(Module $module, Server $server, array $data = []): array
    {
        $password = Str::random(10);

        return [
            'password' => $password,
            'databaseUsers' => $this->getDatabaseUsers($server, $password),
            'hosts' => [$server->ip, 'localhost'],
        ];
    }

    /**
     * @param Server $server
     * @param string $password
     * @return Collection
     */
    protected function getDatabaseUsers(Server $server, string $password): Collection
    {
        return collect($server->toConfiguration()->systemUsers())
            ->map(function ($user) use ($server, $password) {
                return new User($user->name, $password, ['*.*']);
            });
    }
}