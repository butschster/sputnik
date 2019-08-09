<?php

namespace App\Http\Actions\Server\Site;

use App\Models\Server;
use App\Validation\Rules\Server\PublicKey;
use Illuminate\Support\Str;
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
