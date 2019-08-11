<?php

namespace App\Http\Requests;

use App\Contracts\Request\RequestSignatureHandler as RequestSignatureHandlerContract;
use Carbon\Carbon;

class RequestSignatureHandler implements RequestSignatureHandlerContract
{
    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @param string $secretKey
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Create signature for given parameters
     *
     * @param array $parameters
     * @param Carbon|null $expiration
     *
     * @return array
     */
    public function signParameters(array $parameters = [], Carbon $expiration = null): array
    {
        if ($expiration) {
            $parameters['expires'] = $expiration->getTimestamp();
        }

        $parameters['signature'] = hash_hmac('sha256', $this->hashData($parameters), $this->secretKey);

        return $parameters;
    }

    /**
     * @param string $signature
     * @param array $parameters
     * @param int|null $expires
     *
     * @return bool
     */
    public function validate(string $signature, array $parameters = [], int $expires = null): bool
    {
        if (!is_null($expires)) {
            $parameters['expires'] = $expires;
        }

        $hash = hash_hmac('sha256', $this->hashData($parameters), $this->secretKey);

        return hash_equals($hash, $signature) &&
            !(!is_null($expires) && \Illuminate\Support\Carbon::now()->getTimestamp() > $expires);
    }

    /**
     * @param array $parameters
     *
     * @return string
     */
    protected function hashData(array $parameters): string
    {
        ksort($parameters);

        return md5(json_encode($parameters));
    }
}
