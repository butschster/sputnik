<?php

namespace App\Contracts\Http\WebHooks;

use Illuminate\Http\Request;

interface Manager
{
    /**
     * @param Request $request
     * @param mixed ...$args
     */
    public function call(Request $request, ...$args): void;
}
