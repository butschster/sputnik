<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\AlertsCollection;
use App\Models\Server;

class AlertsController extends Controller
{
    /**
     * @param Server $server
     *
     * @return AlertsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): AlertsCollection
    {
        $this->authorize('show', $server);

        return AlertsCollection::make($server->alerts);
    }
}