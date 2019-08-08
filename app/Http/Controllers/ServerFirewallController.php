<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Firewall\StoreRequest;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;

class ServerFirewallController extends Controller
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
