<?php

namespace App\Http\Controllers;

use App\Models\Server;

class ServerController extends Controller
{
    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Server $server)
    {
        return view('server.show', compact('server'));
    }

    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installationScript(Server $server)
    {
        return view('scripts.server.key_installation', compact('server'));
    }
}
