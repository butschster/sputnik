<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\EventResource;
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
    public function index(Server $server): EventsCollection
    {
        $this->authorize('show', $server);

        return EventsCollection::make($server->events()->latest()->paginate(10));
    }

    /**
     * @param Server $server
     * @return EventResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function last(Server $server): EventResource
    {
        $this->authorize('show', $server);

        return EventResource::make($server->events()->latest()->firstOrFail());
    }
}
