<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServerUsersController extends Controller
{
    public function index(Server $server)
    {
        return view('server.user.index', [
            'server' => $server,
            'users' => $server->users
        ]);
    }

    /**
     * @param Request $request
     * @param Server $server
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Server $server)
    {
        // Check if server is configured
        $data = $this->validate($request, [
            'name' => [
                'required',
                'string',
                Rule::unique('server_users')->where('server_id', $server->id)
            ]
        ]);

        $server->users()->create($data);

        return back();
    }

    /**
     * @param $server
     * @param Server\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($server, Server\User $user)
    {
        $user->delete();

        return back();
    }
}
