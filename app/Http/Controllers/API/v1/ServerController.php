<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\StoreRequest;
use App\Http\Resources\v1\Server\EventsCollection;
use App\Http\Resources\v1\ServerCollection;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * @param Request $request
     *
     * @return ServerCollection
     */
    public function index(Request $request): ServerCollection
    {
        $servers = $request->user()->servers()->paginate();

        return ServerCollection::make($servers);
    }

    /**
     * @param Server $server
     *
     * @return ServerResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function events(Server $server): ServerResource
    {
        $this->authorize('show', $server);

        return EventsCollection::make($server->events()->paginate(50));
    }

    /**
     * @param Server $server
     *
     * @return ServerResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server $server): ServerResource
    {
        $this->authorize('show', $server);

        return ServerResource::make($server);
    }

    /**
     * @param StoreRequest $request
     *
     * @return ServerResource
     */
    public function store(StoreRequest $request): ServerResource
    {
        $server = $request->persist();

        return ServerResource::make($server);
    }

    /**
     * @param Server $server
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server $server)
    {
        $this->authorize('delete');

        return $this->responseDeleted();
    }
}
