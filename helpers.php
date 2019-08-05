<?php

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
