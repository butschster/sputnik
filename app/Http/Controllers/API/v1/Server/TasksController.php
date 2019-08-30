<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\TaskResource;
use App\Http\Resources\v1\Server\TasksCollection;
use App\Models\Server;

class TasksController extends Controller
{
    /**
     * @param Server $server
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): TasksCollection
    {
        $this->authorize('show', $server);

        return TasksCollection::make(
            $server->tasks()->paginate()
        );
    }

    /**
     * @param Server\Task $task
     * @return TaskResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\Task $task): TaskResource
    {
        $this->authorize('show', $task);

        return TaskResource::make($task);
    }

    /**
     * @param Server\Task $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return $this->responseDeleted();
    }
}
