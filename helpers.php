<?php

/**
 * Generate API route with version by name
 *
 * @param string $name
 * @param array $parameters
 * @param string $version
 * @return string
 */
function api_route(string $name, $parameters = [], string $version = 'v1'): string
{
    return route('api.' . $version . '.' . $name, $parameters);
}

/**
 * Generate curl callback string
 *
 * @param string $action
 * @param array $parameters
 *
 * @param int $lifeTime link lifetime in minutes
 *
 * @return string
 */
function callback_url(string $action, array $parameters = [], int $lifeTime = 60): string
{
    return app(\App\Utils\SSH\CallbackCurlGenerator::class)->generate($action, $parameters, $lifeTime);
}
