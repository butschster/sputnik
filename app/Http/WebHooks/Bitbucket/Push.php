<?php

namespace App\Http\WebHooks\Bitbucket;

use App\Contracts\Http\WebHooks\WebHook;
use Illuminate\Http\Request;

class Push implements WebHook
{
    /**
     * @param Request $request
     * @return bool
     */
    public function isValid(Request $request): bool
    {
        return $request->hasHeader('X-Event-Key')
            && $request->header('X-Event-Key') === 'repo:push';
    }
}