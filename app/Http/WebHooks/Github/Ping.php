<?php

namespace App\Http\WebHooks\Github;

use App\Contracts\Http\WebHooks\WebHook;
use Illuminate\Http\Request;

class Ping implements WebHook
{
    /**
     * @param Request $request
     * @return bool
     */
    public function isValid(Request $request): bool
    {
        return $request->hasHeader('X-GitHub-Event')
            && $request->header('X-GitHub-Event') === 'ping';
    }
}