<?php

namespace Module\Scheduler\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Module\Scheduler\Http\Requests\CronJob\StoreRequest;
use Module\Scheduler\Http\Resources\v1\CronJobCollection;
use Module\Scheduler\Http\Resources\v1\CronJobResource;
use Module\Scheduler\Models\CronJob;

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

        return CronJobCollection::make(
            CronJob::forServer($server)->get()
        );
    }

    /**
     * @param Server\CronJob $job
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(CronJob $job): CronJobResource
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
     * @param CronJob $job
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(CronJob $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return $this->responseDeleted();
    }
}
