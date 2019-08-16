<?php

namespace App\Http\Middleware;

use App\Exceptions\Subscription\ActiveSubscriptionNotFound;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class HasSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            throw new AuthenticationException();
        }

        if (!Auth::user()->hasActiveSubscription()) {
            throw new ActiveSubscriptionNotFound(302);
        }

        return $next($request);
    }
}
