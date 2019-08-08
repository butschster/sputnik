<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\CronJob\StoreRequest;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;

class ServerSchedulerController extends Controller
{

    /**
     * @param StoreRequest $request
     *
     * @return ServerResource
     */
    public function store(StoreRequest $request, Server $server)
    {
        $request->persist();

        return redirect(route('server.show', $server));
    }

}
