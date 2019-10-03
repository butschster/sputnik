<?php

namespace Module\Mysql\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Module\Mysql\Http\Requests\Database\StoreRequest;
use Module\Mysql\Http\Resources\v1\DatabaseCollection;
use Module\Mysql\Http\Resources\v1\DatabaseResource;
use Module\Mysql\Models\Database;

class DatabaseController extends Controller
{
    /**
     * @param Server $server
     * @return DatabaseCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): DatabaseCollection
    {
        $this->authorize('show', $server);

        return DatabaseCollection::make(
            Database::forServer($server)->get()
        );
    }

    /**
     * @param Database $database
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Database $database): DatabaseResource
    {
        $this->authorize('show', $database);

        return DatabaseResource::make($database);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return DatabaseResource
     */
    public function store(StoreRequest $request, Server $server): DatabaseResource
    {
        $database = $request->persist();

        return DatabaseResource::make($database);
    }

    /**
     * @param Database $database
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Database $database)
    {
        $this->authorize('delete', $database);

        $database->delete();

        return $this->responseDeleted();
    }
}
