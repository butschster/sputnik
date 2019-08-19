<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\StoreRequest;
use App\Http\Resources\v1\ServerResource;
use App\Models\Server;
use App\Models\User\Team;
use App\Scripts\Server\Configure;
use App\Services\Server\FirewallService;
use Illuminate\Http\Request;

/**
 * TODO Remove this
 */
class ServerController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $servers = $request->user()->servers;

        return view('home', [
            'servers' => $servers,
            'teams' => $request->user()->rolesTeams->filter(function (Team $team) {
                return \Gate::allows('store', [Server::class, $team]);
            })
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
        $sysInfo = $server->systemInformation();

        $data = compact('server', 'sysInfo');

        if ($sysInfo && !$sysInfo->isSupported()) {
            return view('server.not_supported', $data);
        }

        return view('server.show', $data);
    }

    /**
     * @param Server $server
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function config(Server $server)
    {
        $script = new Configure($server);

        return view('server.config', compact('script'));
    }

    /**
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Server $server)
    {
        $server->delete();

        return redirect(route('home'));
    }
}
