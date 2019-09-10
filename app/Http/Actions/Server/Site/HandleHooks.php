<?php

namespace App\Http\Actions\Server\Site;

use App\Contracts\Http\WebHooks\Manager;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class HandleHooks extends Action
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'site_id' => ['required', Rule::exists('server_sites', 'id')],
        ];
    }

    /**
     * @param Request $request
     * @param Manager $manager
     */
    public function handle(Request $request, Manager $manager): void
    {
        $site = Server\Site::findOrFail($request->site_id);
        $manager->call($request, $site);
    }
}
