<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerSupervisorController extends Controller
{
    public function index(Server $server)
    {
        return view('server.supervisor.index', [
            'server' => $server,
            'tasks' => $server->tasks()->for(Server\Daemon::class)->paginate(),
            'daemons' => $server->daemons
        ]);
    }

    /**
     * @param Request $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Server $server)
    {
        $data = $this->validate($request, [
            'command' => 'required|string',
            'processes' => 'required|numeric|min:1|max:100',
            'user' => 'required',
            'directory' => 'nullable|string',
        ]);

        $server->daemons()->create($data);

        return back();
    }

    public function delete($server, Server\Daemon $daemon)
    {
        $daemon->delete();

        return back();
    }
}
