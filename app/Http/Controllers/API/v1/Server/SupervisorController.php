<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Supervisor\StoreRequest;
use App\Http\Resources\v1\Server\DaemonResource;
use App\Http\Resources\v1\Server\DaemonsCollection;
use App\Models\Server;

class SupervisorController extends Controller
{
    /**
     * @param Server $server
     * @return DaemonsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): DaemonsCollection
    {
        $this->authorize('show', $server);

        $daemons = $server->daemons()->get();

        return DaemonsCollection::make($daemons);
    }

    /**
     * @param Server\Daemon $daemon
     * @return DaemonResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\Daemon $daemon): DaemonResource
    {
        $this->authorize('show', $daemon);

        return DaemonResource::make($daemon);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return DaemonResource
     */
    public function store(StoreRequest $request, Server $server): DaemonResource
    {
        $daemon = $request->persist();

        return DaemonResource::make($daemon);
    }

    /**
     * @param Server\Daemon $daemon
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\Daemon $daemon)
    {
        $this->authorize('delete', $daemon);

        $daemon->delete();

        return $this->responseDeleted();
    }
}
