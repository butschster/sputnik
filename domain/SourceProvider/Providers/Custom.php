<?php

namespace Domain\SourceProvider\Providers;

use Domain\SourceProvider\Contracts\SourceProvider;
use Illuminate\Support\Collection;

class Custom implements SourceProvider
{

    /**
     * Get clone url
     *
     * @param string $repository
     * @return string
     */
    public function cloneUrl(string $repository): string
    {
        // TODO: Implement cloneUrl() method.
    }

    /**
     * Get available web hooks
     *
     * @param string $repository
     *
     * @return Collection
     */
    public function getHooks(string $repository): Collection
    {
        // TODO: Implement getHooks() method.
    }

    /**
     * Create new web hook
     *
     * @param string $repository
     * @param string $url
     * @return bool
     */
    public function addHook(string $repository, string $url): bool
    {
        // TODO: Implement addHook() method.
    }

    /**
     * Delete web hook
     *
     * @param string $repository
     * @param string $url
     * @return bool
     */
    public function deleteHook(string $repository, string $url): bool
    {
        // TODO: Implement deleteHook() method.
    }

    /**
     * Add new public key
     *
     * @param string $repository
     * @param string $content
     * @return bool
     */
    public function addPublicKey(string $repository, string $content): bool
    {
        // TODO: Implement addPublicKey() method.
    }

    /**
     * Validate the given repository and branch are valid.
     *
     * @param string $repository
     * @param string $branch
     * @return bool
     */
    public function validRepository(string $repository, string $branch): bool
    {
        // TODO: Implement validRepository() method.
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
        // TODO: Implement request() method.
    }
}
