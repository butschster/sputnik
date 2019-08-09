<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Site\StoreRequest;
use App\Models\Server;

class ServerSitesController extends Controller
{
    /**
     * @param Server\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($server, Server\Site $site)
    {
        return view('server.site.show', compact('site'));
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request, Server $server)
    {
        $site = $request->persist();

        return redirect(route('server.site.show', $server, $site));
    }

    /**
     * @param Server\Site $site
     * @return \Illuminate\Foundation\Testing\TestResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Server\Site $site)
    {
        $site->delete();

        return redirect(route('server.show', $site->server));
    }
}
