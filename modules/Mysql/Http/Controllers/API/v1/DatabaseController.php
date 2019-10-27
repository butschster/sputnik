<?php

namespace Module\Mysql\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\RecordResource;
use App\Http\Resources\v1\Server\RecordsCollection;
use App\Models\Server;
use Domain\Module\Validation\Rules\ModuleInstalled;
use Domain\Record\Repositories\RecordRepository;
use Illuminate\Http\Request;
use Module\Mysql\DatabaseService;
use Module\Mysql\Http\Requests\Database\StoreRequest;

class DatabaseController extends Controller
{
    /**
     * @var RecordRepository
     */
    protected $repository;

    /**
     * @var DatabaseService
     */
    protected $service;

    /**
     * @param RecordRepository $repository
     * @param DatabaseService $service
     */
    public function __construct(RecordRepository $repository, DatabaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Server $server
     * @return RecordsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request, Server $server): RecordsCollection
    {
        $this->authorize('show', $server);

        $this->validate($request, [
            'module' => [
                'required',
                new ModuleInstalled($server)
            ]
        ]);

        return RecordsCollection::make(
            $this->repository->list($server, $request->module, 'database')
        );
    }

    /**
     * @param string $database
     * @return RecordResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(string $database): RecordResource
    {
        $record = $this->repository->find($database);
        $this->authorize('show', $record);

        return RecordResource::make($record);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return RecordResource
     */
    public function store(StoreRequest $request, Server $server): RecordResource
    {
        $record = $request->persist();

        $this->service->create($record);

        return RecordResource::make($record);
    }

    /**
     * @param string $database
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(string $database)
    {
        $this->authorize(
            'delete', $record = $this->repository->find($database)
        );

        if ($this->repository->delete($database)) {
            $this->service->delete($record);
        }

        return $this->responseDeleted();
    }
}
