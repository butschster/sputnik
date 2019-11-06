<?php

namespace Domain\SourceProvider\Entities;

use App\Models\User\SourceProvider;
use Domain\SourceProvider\Contracts\SourceProvider as SourceProviderContract;
use GuzzleHttp\Client;

abstract class Provider implements SourceProviderContract
{
    /**
     * The source instance.
     *
     * @var SourceProvider
     */
    protected $source;

    /**
     * Create a new GitHub service instance.
     *
     * @param SourceProvider $source
     * @return void
     */
    public function __construct(SourceProvider $source)
    {
        $this->source = $source;
    }

    /**
     * Make an HTTP request.
     *
     * @param string $method
     * @param string $path
     * @param array $parameters
     * @return array
     */
    public function request(string $method, string $path, array $parameters = []): array
    {
        $response = (new Client())->{$method}($this->buildUrl($path), [
            'headers' => [
                'Authorization' => $this->authHeader(),
            ],
            'json' => $parameters,
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @return string
     */
    abstract protected function authHeader(): string;

    /**
     * @param string $path
     *
     * @return string
     */
    abstract protected function buildUrl(string $path): string;
}
