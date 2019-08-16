<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Firewall\StoreRequest;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;

class ServerFirewallController extends Controller
{
    public function index(Server $server)
    {
        return view('server.firewall.index', [
            'server' => $server,
            'rules' => $server->firewallRules
        ]);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request, Server $server)
    {
        $request->persist();

        return back();
    }

}
