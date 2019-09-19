<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;

class ToolsDictionaryController extends Controller
{
    /**
     * @return array
     */
    public function types()
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
    public function phpVersions()
    {
        $versions = config('configurations.php', []);

        return collect($versions)->map(function (string $version) {
            return [
                'label' => trans('server.php_versions.' . $version),
                'value' => $version,
            ];
        });
    }

    /**
     * @return array
     */
    public function databaseTypes()
    {
        $databases = config('configurations.database', []);

        return collect($databases)->map(function (string $type) {
            return [
                'label' => trans('server.databases.' . $type),
                'value' => $type,
            ];
        });
    }

    /**
     * @return array
     */
    public function webserverTypes()
    {
        $webservers = config('configurations.webserver', []);
        return collect($webservers)->map(function (string $type) {
            return [
                'label' => trans('server.web_servers.' . $type),
                'value' => $type,
            ];
        });
    }
}
