<?php

namespace App\Contracts\Http\WebHooks;

use App\Models\Server\Site;
use Illuminate\Http\Request;

interface Manager
{
    /**
     * @param Request $request
     * @param Site $site
     */
    public function call(Request $request, Site $site): void;
}