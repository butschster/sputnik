<?php

namespace App\Http\Actions\Server\Site;

use App\Models\Server;
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

    public function handle(): void
    {
        $site = Server\Site::findOrFail($this->site_id);


    }
}
