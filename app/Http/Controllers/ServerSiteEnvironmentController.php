<?php

namespace App\Http\Controllers;

use App\Models\Server\Site;
use Dotenv\Dotenv;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Loader;
use Illuminate\Http\Request;

class ServerSiteEnvironmentController extends Controller
{
    public function index($server, Site $site)
    {
        return view('server.site.environment.index', [
            'site' => $site,
        ]);
    }

    /**
     * @param Request $request
     * @param $server
     * @param Site $site
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload(Request $request, $server, Site $site)
    {
        $this->validate($request, [
            'file' => 'required|file',
        ]);

        $loader = new Loader([],  new DotenvFactory());

        try {
            $data = $loader->loadDirect(
                file_get_contents($request->file('file')->openFile()->getRealPath())
            );
        } catch (InvalidFileException $e) {
            return back()->withErrors(['file' => 'Invalid file']);
        }

        $site->update([
            'environment' => $data
        ]);

        return back();
    }
    /**
     * @param Request $request
     * @param $server
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $server, Site $site)
    {
        $this->validate($request, [
            'key' => 'required|string',
            'value' => 'required|string'
        ]);

        $environment = $site->environment ?? [];

        $environment[$request->key] = $request->value;
        $site->update([
            'environment' => $environment
        ]);

        return back();
    }

    /**
     * @param Request $request
     * @param $server
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request, $server, Site $site)
    {
        $this->validate($request, [
            'key' => 'required|string',
        ]);

        $environment = $site->environment ?? [];
        unset($environment[$request->key]);

        $site->update([
            'environment' => $environment
        ]);

        return back();
    }
}
