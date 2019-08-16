<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\CronJob\StoreRequest;
use App\Http\Resources\v1\Server\CronJobCollection;
use App\Http\Resources\v1\Server\CronJobResource;
use App\Models\Server;

class SchedulerController extends Controller
{
    /**
     * @param Server $server
     * @return CronJobCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): CronJobCollection
    {
        $this->authorize('show', $server);

        $jobs = $server->cronJobs()->paginate();

        return CronJobCollection::class($jobs);
    }

    /**
     * @param Server\CronJob $job
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\CronJob $job): CronJobResource
    {
        $this->authorize('show', $job);

        return CronJobResource::make($job);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return CronJobResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request, Server $server): CronJobResource
    {
        $job = $request->persist();

        return CronJobResource::make($job);
    }

    /**
     * Remove cron jobs from the server
     *
     * @param Server\CronJob $job
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\CronJob $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return $this->responseDeleted();
    }
}
