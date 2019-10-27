<?php

namespace Module\Supervisor\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Domain\Record\Repositories\RecordRepository;
use Module\Supervisor\DaemonService;
use Module\Supervisor\Http\Requests\Daemon\StoreRequest;
use Module\Supervisor\Http\Resources\v1\DaemonResource;
use Module\Supervisor\Http\Resources\v1\DaemonsCollection;

class SupervisorController extends Controller
{
    /**
     * @var RecordRepository
     */
    protected $repository;

    /**
     * @var DaemonService
     */
    protected $service;

    /**
     * @param RecordRepository $repository
     * @param DaemonService $service
     */
    public function __construct(RecordRepository $repository, DaemonService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param Server $server
     * @return DaemonsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): DaemonsCollection
    {
        $this->authorize('show', $server);

        return DaemonsCollection::make(
            $this->repository->list($server, 'supervisor', 'daemon')
        );
    }

    /**
     * @param string $daemon
     * @return DaemonResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(string $daemon): DaemonResource
    {
        $record = $this->repository->find($daemon);

        $this->authorize('show', $record);

        return DaemonResource::make($record);
    }

    /**
     * @param string $daemon
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restart(string $daemon)
    {
        $record = $this->repository->find($daemon);
        $this->authorize('show', $record);

        $this->service->restart($record);

        return $this->responseOk();
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return DaemonResource
     */
    public function store(StoreRequest $request, Server $server): DaemonResource
    {
        $record = $request->persist();

        $this->service->start($record);

        return DaemonResource::make($record);
    }

    /**
     * @param string $daemon
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(string $daemon)
    {
        $this->authorize(
            'delete', $record = $this->repository->find($daemon)
        );

        if ($this->repository->delete($daemon)) {
            $this->service->stop($record);
        }

        return $this->responseDeleted();
    }
}
