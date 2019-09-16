<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\SearchRequest;
use App\Http\Requests\Server\StoreRequest;
use App\Http\Requests\Server\UpdateRequest;
use App\Http\Resources\v1\ServerCollection;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;
use App\Scripts\Server\Configure;
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
        $servers = $request->user()->servers()->with('team', 'user')->get();

        return ServerCollection::make($servers);
    }

    /**
     * @param SearchRequest $request
     * @return ServerCollection
     */
    public function search(SearchRequest $request): ServerCollection
    {
        return ServerCollection::make(
            $request->search()
        );
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
     * @return ServerResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request): ServerResource
    {
        $server = $request->persist();

        return ServerResource::make($server);
    }

    /**
     * @param UpdateRequest $request
     * @param Server $server
     * @return ServerResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, Server $server): ServerResource
    {
        $request->persist();

        return ServerResource::make($server);
    }

    /**
     * @param Server $server
     * @return Configure
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function installScript(Server $server)
    {
        $this->authorize('show', $server);

        return new Configure($server);
    }

    /**
     * @param Server $server
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server $server)
    {
        $this->authorize('delete', $server);

        $server->delete();

        return $this->responseDeleted();
    }
}
