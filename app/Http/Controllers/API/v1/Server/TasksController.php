<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\TaskResource;
use App\Http\Resources\v1\Server\TasksCollection;
use App\Http\Resources\v1\Server\TaskWithContentResource;
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
     * @return TaskWithContentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\Task $task): TaskWithContentResource
    {
        $this->authorize('show', $task);

        return TaskWithContentResource::make($task);
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
