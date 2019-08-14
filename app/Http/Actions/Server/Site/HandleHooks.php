<?php

namespace App\Http\Actions\Server\Site;

use App\Contracts\Http\WebHooks\WebHookManager;
use App\Jobs\Server\Site\Deploy;
use App\Models\Server;
use App\Services\SourceProviders\Factory;
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
     * @param Factory $factory
     */
    public function handle(Request $request, Factory $factory): void
    {
        $site = Server\Site::findOrFail($request->site_id);

//        dispatch(
//            new Deploy($site)
//        );
    }
}
