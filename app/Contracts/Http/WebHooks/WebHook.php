<?php

namespace App\Contracts\Http\WebHooks;

use Illuminate\Http\Request;

interface WebHook
{
    public function isValid(Request $request): bool;
}