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
    return app(\Domain\SSH\Bash\CallbackCurlGenerator::class)->generate($action, $parameters, $lifeTime);
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
 * @param string $path
 *
 * @return string
 */
function modules_path(string $path = ''): string
{
    return app(App\Contracts\Modules\ManagerInterface::class)->basePath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}


function site_configurator(): \Domain\Site\Configurator {
    return app(\Domain\Site\Contracts\Configurator::class);
}