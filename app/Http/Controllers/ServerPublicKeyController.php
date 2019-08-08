<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Key\StoreRequest;
use App\Models\Server;

class ServerPublicKeyController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request, Server $server)
    {
        $request->persist();

        return redirect(route('server.show', $server));
    }
}
