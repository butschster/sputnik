<?php

namespace App\Services\SourceProviders\Contracts;

use Illuminate\Support\Collection;

interface SourceProvider
{
    /**
     * Get clone url
     *
     * @param string $repository
     * @return string
     */
    public function cloneUrl(string $repository): string;

    /**
     * Get available web hooks
     *
     * @param string $repository
     *
     * @return Collection
     */
    public function getHooks(string $repository): Collection;

    /**
     * Create new web hook
     *
     * @param string $repository
     * @param string $url
     * @return bool
     */
    public function addHook(string $repository, string $url): bool;

    /**
     * Delete web hook
     *
     * @param string $repository
     * @param string $url
     * @return bool
     */
    public function deleteHook(string $repository, string $url): bool;

    /**
     * Add new public key
     *
     * @param string $repository
     * @param string $content
     * @return bool
     */
    public function addPublicKey(string $repository, string $content): bool;

    /**
     * Validate the given repository and branch are valid.
     *
     * @param string $repository
     * @param string $branch
     * @return bool
     */
    public function validRepository(string $repository, string $branch): bool;

    /**
     * Make an HTTP request.
     *
     * @param string $method
     * @param string $path
     * @param array $parameters
     * @return array
     */
    public function request(string $method, string $path, array $parameters = []): array;
}
