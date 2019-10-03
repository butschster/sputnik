<?php

namespace Module\Supervisor\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Module\Supervisor\DaemonService;
use Module\Supervisor\Http\Requests\Daemon\StoreRequest;
use Module\Supervisor\Http\Resources\v1\DaemonResource;
use Module\Supervisor\Http\Resources\v1\DaemonsCollection;
use Module\Supervisor\Models\Daemon;

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

        return DaemonsCollection::make(
            Daemon::forServer($server)->get()
        );
    }

    /**
     * @param Daemon $daemon
     * @return DaemonResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Daemon $daemon): DaemonResource
    {
        $this->authorize('show', $daemon);

        return DaemonResource::make($daemon);
    }

    /**
     * @param DaemonService $service
     * @param Server\Daemon $daemon
     * @return DaemonResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(DaemonService $service, Server\Daemon $daemon)
    {
        $this->authorize('show', $daemon);

        $service->restart($daemon);

        return $this->responseOk();
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
     * @param Daemon $daemon
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Daemon $daemon)
    {
        $this->authorize('delete', $daemon);

        $daemon->delete();

        return $this->responseDeleted();
    }
}
