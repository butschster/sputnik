<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\CronJob\StoreRequest;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;

class ServerSchedulerController extends Controller
{
    public function index(Server $server)
    {
        return view('server.scheduler.index', [
            'server' => $server,
            'tasks' => $server->tasks()->for(Server\CronJob::class)->paginate(),
            'jobs' => $server->cronJobs
        ]);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request, Server $server)
    {
        $request->persist();

        return back();
    }

}
