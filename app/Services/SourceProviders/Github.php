<?php

namespace App\Services\SourceProviders;

use App\Utils\SSH\ValueObjects\PublicKey;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;

class Github extends SourceProvider
{
    /**
     * Get available web hooks
     *
     * @param string $repository
     *
     * @return Collection
     */
    public function getHooks(string $repository): Collection
    {
        return collect(
            $this->request('get', "/repos/{$repository}/hooks")
        );
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
        try {
            $this->getHooks($repository)->filter(function ($hook) use ($url) {
                return $hook['config']['url'] === $url;
            })->each(function ($hook) use ($repository) {
                $this->request('delete', "/repos/{$repository}/hooks/" . $hook['id']);
            });

            return true;
        } catch (ClientException $e) {

        }

        return false;
    }

    /**
     * @param string $repository
     * @param string $url
     * @return bool
     */
    public function addHook(string $repository, string $url): bool
    {
        $hooks = $this->getHooks($repository);

        $hooks = $hooks->filter(function ($hook) use ($url) {
            return $hook['config']['url'] === $url;
        });

        if ($hooks->count() > 0) {
            return true;
        }

        try {
            $this->request('post', "/repos/{$repository}/hooks", [
                'title' => 'Webhook [sputnik]',
                'config' => [
                    'url' => $url,
                    'content_type' => 'json',
                ],
                'events' => [
                    'push',
                ],
            ]);

            return true;
        } catch (ClientException $e) {

        }

        return false;
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
        $keys = $this->request('get', "/repos/{$repository}/keys");

        $keys = collect($keys)->filter(function ($key) use ($content) {
            return (new PublicKey($key['title'], $key['key']))
                ->is(new PublicKey('test', $content));
        });

        if ($keys->count() > 0) {
            return true;
        }

        try {
            $this->request('post', "/repos/{$repository}/keys", [
                'title' => 'Deployment key [sputnik]',
                'key' => $content,
                'read_only' => false,
            ]);

            return true;
        } catch (ClientException $e) {

        }

        return false;
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
        if (empty($repository)) {
            return false;
        }

        try {
            $response = $this->request('get', "/repos/{$repository}/branches");
        } catch (ClientException $e) {
            return false;
        }

        if (empty($branch)) {
            return true;
        }

        return collect($response)->contains(function ($b) use ($branch) {
            return $b['name'] === $branch;
        });
    }

    /**
     * Get the authentication token for the provider.
     *
     * @return string
     */
    protected function getToken(): string
    {
        return $this->source->access_token;
    }

    /**
     * Get clone url
     *
     * @param string $repository
     * @return string
     */
    public function cloneUrl(string $repository): string
    {
        return "git@github.com:{$repository}.git";
    }

    /**
     * @return string
     */
    protected function authHeader(): string
    {
        return 'token ' . $this->getToken();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function buildUrl(string $path): string
    {
        return 'https://api.github.com/' . ltrim($path, '/');
    }
}
