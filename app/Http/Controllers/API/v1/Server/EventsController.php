<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\EventsCollection;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;

class EventsController extends Controller
{
    /**
     * @param Server $server
     *
     * @return ServerResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): ServerResource
    {
        $this->authorize('show', $server);

        return EventsCollection::make($server->events()->paginate(50));
    }
}
