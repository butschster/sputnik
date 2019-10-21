<?php

namespace Module\Mysql;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Models\Server;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Module\Mysql\ValueObjects\User;

class DatabaseSettings implements Extension
{
    /**
     * {@inheritDoc}
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function scriptData(Module $module, Server $server, array $data = []): array
    {
        return [
            'databaseUsers' => $this->getDatabaseUsers($server, $data['password']),
            'hosts' => [$server->ip, 'localhost'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function databaseData(Module $module, Server $server, array $data = []): array
    {
        $password = Str::random(10);

        return [
            'password' => $password,
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