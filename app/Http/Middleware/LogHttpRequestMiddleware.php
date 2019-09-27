<?php

namespace App\Http\Middleware;

use Closure;
use Psr\Log\LoggerInterface;

class LogHttpRequestMiddleware
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->logger->debug('Request', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'data' => $request->all(),
            'query' => $request->query(),
            'ip' => $request->ip(),
        ]);

        return $next($request);
    }
}
