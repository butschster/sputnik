<?php

namespace App\Services\SourceProviders;

use App\Utils\SSH\ValueObjects\PublicKey;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;

class Bitbucket extends SourceProvider
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
        $hooks = $this->request('get', "/repositories/{$repository}/hooks");

        return collect($hooks['values']);
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
            return $hook['url'] === $url;
        });

        if ($hooks->count() > 0) {
            return true;
        }

        try {
            $this->request('post', "/repositories/{$repository}/hooks", [
                'description' => 'Webhook [sputnik]',
                'url' => $url,
                'active' => true,
                'events' => [
                    'repo:push'
                ]
            ]);

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
    public function deleteHook(string $repository, string $url): bool
    {
        try {
            $this->getHooks($repository)->filter(function ($hook) use ($url) {
                return $hook['url'] === $url;
            })->each(function ($hook) use ($repository) {
                $this->request('delete', "/repositories/{$repository}/hooks/" . $hook['uuid']);
            });

            return true;
        } catch (ClientException $e) {

        }

        return false;
    }

    /**
     * @param string $repository
     * @param string $content
     * @return bool
     */
    public function addPublicKey(string $repository, string $content): bool
    {
        $keys = $this->request('get', "/repositories/{$repository}/deploy-keys");

        $keys = collect($keys['values'])->filter(function ($key) use ($content) {
            return (new PublicKey($key['label'], $key['key']))
                ->is(new PublicKey('test', $content));
        });

        if ($keys->count() > 0) {
            return true;
        }

        try {
            $this->request('post', "/repositories/{$repository}/deploy-keys", [
                'label' => 'Deployment key [sputnik]',
                'key' => $content
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
        return "git@bitbucket.org:{$repository}.git";
    }

    /**
     * @return string
     */
    protected function authHeader(): string
    {
        return 'Bearer ' . $this->getToken();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function buildUrl(string $path): string
    {
        return 'https://api.bitbucket.org/2.0/' . ltrim($path, '/');
    }
}
