<?php

namespace App\Utils\SSH;

use Carbon\Carbon;

class CallbackCurlGenerator
{
    /**
     * Generate curl string with callbakc url and data
     *
     * @param string $action
     * @param array $parameters
     * @param int $lifeTime
     *
     * @return string
     */
    public function generate(string $action, array $parameters = [], int $lifeTime = 60)
    {
        $url = route('callback');

        $parameters = array_merge(
            $parameters,
            $this->signature($url, ['action' => $action], now()->addMinutes($lifeTime))
        );

        return sprintf('curl -X POST -k -d "%s" %s > /dev/null 2>&1',
            $this->buildData($parameters),
            $url
        );
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param Carbon $expiration
     * @return array
     */
    protected function signature(string $url, array $parameters, Carbon $expiration)
    {
        $parameters += ['expires' => $expiration->getTimestamp()];

        ksort($parameters);

        return $parameters + [
            'signature' => hash_hmac('sha256', $url, config('app.key')),
        ];
    }

    /**
     * Build query string with data from parameters
     *
     * @param array $parameters
     *
     * @return string
     */
    protected function buildData(array $parameters): string
    {
        return urldecode(http_build_query($parameters));
    }
}
