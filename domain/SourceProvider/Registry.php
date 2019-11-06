<?php

namespace Domain\SourceProvider;

use Domain\SourceProvider\Contracts\Registry as RegistryContract;
use Domain\SourceProvider\Exceptions\SourceProviderNotFoundException;
use Domain\SourceProvider\ValueObjects\SourceProvider;
use Illuminate\Support\Collection;

class Registry implements RegistryContract
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * {@inheritDoc}
     */
    public function register(SourceProvider $provider): void
    {
        $this->providers[$provider->getType()] = $provider;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $provider): SourceProvider
    {
        if (!isset($this->providers[$provider])) {
            throw new SourceProviderNotFoundException("Provider {$provider} not found");
        }

        return $this->providers[$provider];
    }

    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return collect($this->providers);
    }
}
