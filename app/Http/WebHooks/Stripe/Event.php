<?php

namespace App\Http\WebHooks\Stripe;

use App\Contracts\Http\WebHooks\WebHook;
use Illuminate\Http\Request;

class Event implements WebHook
{
    /**
     * @param Request $request
     * @return bool
     */
    public function isValid(Request $request): bool
    {
        return $request->hasHeader('Stripe-Signature');
    }
}
