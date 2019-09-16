<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;

class ToolsDictionaryController extends Controller
{
    /**
     * @return array
     */
    public function types(): array
    {
        $types = config('configurations.server_types', []);

        return collect($types)->map(function (string $type) {
            return [
                'label' => trans('server.types.' . $type),
                'value' => $type,
            ];
        });
    }

    /**
     * @return array
     */
    public function phpVersions(): array
    {
        return [
            [
                'label' => 'PHP 7.2',
                'value' => 72,
            ],
            [
                'label' => 'PHP 7.3',
                'value' => 73,
            ],
        ];
    }

    /**
     * @return array
     */
    public function databaseTypes(): array
    {
        return [
            [
                'label' => 'MySQL 5.7',
                'value' => 'mysql',
            ],
            [
                'label' => 'MySQL 8',
                'value' => 'mysql8',
            ],
            [
                'label' => 'MariaDB',
                'value' => 'mariadb',
            ],
            [
                'label' => 'PostgreSQL',
                'value' => 'pgsql',
            ],
        ];
    }

    public function webserverTypes(): array
    {
        return [
            [
                'label' => 'Nginx',
                'value' => 'nginx',
            ],
            [
                'label' => 'Caddy',
                'value' => 'caddy',
            ],
        ];
    }
}
