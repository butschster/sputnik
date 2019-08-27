<?php

use App\Contracts\Server\ServerConfiguration;
use App\Scripts\ServerConfigurationManager;

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

/**
 * Generate curl callback event string
 *
 * @param string $serverId
 * @param string $message
 * @param int $progress
 * @return string
 */
function callback_event(string $serverId, string $message, int $progress = 0): string
{
    return callback_url('server.event', [
        'server_id' => $serverId, 'message' => $message, 'progress' => $progress,
    ], 10);
}

/**
 * Get server configurator
 *
 * @param ServerConfiguration $configuration
 * @return ServerConfigurationManager
 */
function server_configurator(ServerConfiguration $configuration): ServerConfigurationManager
{
    return new ServerConfigurationManager(
        $configuration
    );
}
