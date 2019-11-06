<?php

namespace Domain\SourceProvider\Contracts;

use Domain\SourceProvider\ValueObjects\SourceProvider;
use Illuminate\Support\Collection;

interface Registry
{
    /**
     * Register new source provider
     *
     * @param SourceProvider $provider
     */
    public function register(SourceProvider $provider): void;

    /**
     * Get registered source provider
     *
     * @param string $provider
     *
     * @return SourceProvider
     */
    public function get(string $provider): SourceProvider;

    /**
     * Get collection of Source providers
     *
     * @return Collection
     */
    public function all(): Collection;
}
