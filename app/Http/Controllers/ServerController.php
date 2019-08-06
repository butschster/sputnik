<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $servers = $request->user()->servers;

        return view('home', [
            'servers' => $servers,
        ]);
    }

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
