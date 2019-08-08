<?php

namespace App\Http\Controllers;

use App\Models\Server;

class ServerInstallerController extends Controller
{
    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Server $server)
    {
        if (!$server->isPending()) {
            abort(404, 'Server has already configured');
        }

        return view('scripts.server.key_installation', compact('server'));
    }
}
