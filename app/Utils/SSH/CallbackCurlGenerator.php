<?php

namespace App\Utils\SSH;

use App\Contracts\Request\RequestSignatureHandler;

class CallbackCurlGenerator
{
    /**
     * @var RequestSignatureHandler
     */
    protected $signatureHandler;

    /**
     * @param RequestSignatureHandler $signatureHandler
     */
    public function __construct(RequestSignatureHandler $signatureHandler)
    {
        $this->signatureHandler = $signatureHandler;
    }

    /**
     * Generate curl string with callbakc url and data
     *
     * @param string $action
     * @param array $parameters
     * @param int $lifeTime
     *
     * @return string
     */
    public function generate(string $action, array $parameters = [], int $lifeTime = 60): string
    {
        $parameters = array_merge(
            $parameters,
            $this->signatureHandler->signParameters(
                ['action' => $action],
                now()->addMinutes($lifeTime)
            )
        );

        return sprintf('curl -X POST -k -d "%s" %s > /dev/null 2>&1',
            $this->buildData($parameters),
            $this->url()
        );
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return route('callback');
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
        return urldecode(
            http_build_query($parameters)
        );
    }
}
