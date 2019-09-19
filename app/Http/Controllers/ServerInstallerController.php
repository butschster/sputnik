<?php

namespace App\Http\Controllers;

use App\Models\Server;

class ServerInstallerController extends Controller
{
    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Server $server)
    {
        $this->authorize('install-keys', $server);

        return view('scripts.server.keys.install', compact('server'));
    }
}
