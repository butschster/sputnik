<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\StoreRequest;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;
use App\Scripts\Server\Configure;
use App\Services\Server\FirewallService;
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
     * @param StoreRequest $request
     *
     * @return ServerResource
     */
    public function store(StoreRequest $request)
    {
        $server = $request->persist();

        return redirect(route('server.show', $server));
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
    public function config(Server $server)
    {
        return new Configure($server);
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
