<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Database\StoreRequest;
use App\Models\Server;

class ServerDatabaseController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request, Server $server)
    {
        // Todo add checking if database is enabled
        $request->persist();

        return back();
    }

    /**
     * @param $server
     * @param Server\Database $database
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete($server, Server\Database $database)
    {
        $database->delete();

        return back();
    }
}