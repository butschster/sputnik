<?php

namespace App\Http\Middleware;

use App\Models\Server;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class CheckServerTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $types
     *
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, ...$types)
    {
        $server = $request->route()->parameter('server');
        if ($server instanceof Server) {
            if (!in_array($server->type, $types)) {
                throw new AuthorizationException('Wrong server type API');
            }
        }

        return $next($request);
    }
}
