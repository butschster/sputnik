<?php

namespace App\Http\Middleware;

use App\Exceptions\Subscription\ActiveSubscriptionNotFound;
use App\Models\User;
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
     *
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            throw new AuthenticationException();
        }

        /** @var User $user */
        $user = $request->user();

        if (!$user->hasActiveSubscription()) {
            throw new ActiveSubscriptionNotFound(402, 'You don\'t have active subscription');
        }

        return $next($request);
    }
}
