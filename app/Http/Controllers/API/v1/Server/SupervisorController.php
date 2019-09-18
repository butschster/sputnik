<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Supervisor\StoreRequest;
use App\Http\Resources\v1\Server\DaemonResource;
use App\Http\Resources\v1\Server\DaemonsCollection;
use App\Models\Server;
use App\Models\WebServer;
use App\Services\Server\SupervisorService;

class SupervisorController extends Controller
{
    /**
     * @param WebServer $server
     * @return DaemonsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(WebServer $server): DaemonsCollection
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
     * @param SupervisorService $service
     * @param Server\Daemon $daemon
     * @return DaemonResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(SupervisorService $service, Server\Daemon $daemon)
    {
        $this->authorize('show', $daemon);

        $service->restart($daemon);

        return $this->responseOk();
    }

    /**
     * @param StoreRequest $request
     * @param WebServer $server
     * @return DaemonResource
     */
    public function store(StoreRequest $request, WebServer $server): DaemonResource
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
