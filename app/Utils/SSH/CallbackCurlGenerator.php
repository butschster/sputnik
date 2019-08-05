<?php

namespace App\Utils\SSH;

use Illuminate\Support\Facades\URL;

class CallbackCurlGenerator
{
    /**
     * @param string $action
     * @param array $parameters
     * @param int $lifeTime
     *
     * @return string
     */
    public function generate(string $action, array $parameters = [], int $lifeTime = 60)
    {
        $parameters['action'] = $action;

        $url = URL::temporarySignedRoute('callback', now()->addMinutes($lifeTime), ['action' => $action]);

        return sprintf('curl-X POST -k -H "Content-Type: application/json" -d "%s" %s > /dev/null 2>&1',
            $this->buildData($parameters),
            $url
        );
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    protected function buildData(array $parameters): string
    {
        return http_build_query($parameters);
    }
}
