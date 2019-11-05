<?php

namespace Domain\SourceProvider\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Domain\SourceProvider\Events\Connected;
use Domain\SourceProvider\Events\Registered;
use Domain\User\Services\RegisterUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User\SourceProvider;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Facades\Socialite;

abstract class Controller extends BaseController
{
    /**
     * Get provider driver
     *
     * @param string $provider
     * @return Provider
     */
    public function getProvider(string $provider): Provider
    {
        $this->getProviderConfig($provider);

        return Socialite::driver($provider);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param Request $request
     * @param string $provider
     * @return RedirectResponse
     */
    public function login(Request $request, string $provider): RedirectResponse
    {
        return $this->handleProviderRedirect($request, 'login', $provider);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param Request $request
     * @param string $provider
     * @return RedirectResponse
     */
    public function register(Request $request, string $provider): RedirectResponse
    {
        return $this->handleProviderRedirect($request, 'register', $provider);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param Request $request
     * @param string $provider
     * @return RedirectResponse
     */
    public function connect(Request $request, string $provider): RedirectResponse
    {
        return $this->handleProviderRedirect($request, 'connect', $provider);
    }

    /**
     * @param Request $request
     * @param string $action
     * @param string $provider
     * @return mixed
     */
    protected function handleProviderRedirect(Request $request, string $action, string $provider): RedirectResponse
    {
        $request->session()->put('provider_action', $action);

        return $this->getProvider($provider)
            ->setScopes($this->getScopes($provider))
            ->redirect();
    }

    /**
     * @param Request $request
     * @param string $provider
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function handleProviderCallback(Request $request, string $provider): RedirectResponse
    {
        $action = $request->session()->pull('provider_action');

        $providerUser = $this->getProvider($provider)->user();

        switch ($action) {
            case 'login':
                return $this->handleLoginCallback($request, $provider, $providerUser);
            case 'connect':
                return $this->handleConnectCallback($request, $provider, $providerUser);
            case 'register':
                return $this->handleRegisterCallback($request, $provider, $providerUser);
        }

        abort(404);
    }

    /**
     * @param Request $request
     * @param string $provider
     * @param ProviderUser $providerUser
     * @return RedirectResponse
     */
    protected function handleLoginCallback(Request $request, string $provider, ProviderUser $providerUser): RedirectResponse
    {
        try {
            $provider = SourceProvider::where('provider_user_id', $providerUser->getId())->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('login')->withErrors([
                'provider' => trans('auth.provider_failed', [
                    'provider' => trans('auth.provider.' . $provider),
                ]),
            ]);
        }

        auth()->loginUsingId($provider->user_id);

        return redirect()->to('/account');
    }

    /**
     * @param Request $request
     * @param string $provider
     * @param ProviderUser $providerUser
     * @return RedirectResponse
     */
    protected function handleConnectCallback(Request $request, string $provider, ProviderUser $providerUser): RedirectResponse
    {
        if (!auth()->check()) {
            abort(404);
        }

        $request->user()->sourceProviders()->updateOrCreate([
            'type' => $provider,
            'provider_user_id' => $providerUser->getId(),
        ], [
            'access_token' => $providerUser->token,
            'name' => trans('auth.provider.'.$provider),
        ]);

        event(new Connected($provider, $request->user()));

        return redirect()->to('/account');
    }

    /**
     * @param Request $request
     * @param string $provider
     * @param ProviderUser $providerUser
     * @return RedirectResponse
     * @throws \Throwable
     */
    protected function handleRegisterCallback(Request $request, string $provider, ProviderUser $providerUser): RedirectResponse
    {
        if (auth()->check()) {
            abort(404);
        }

        $user = (new RegisterUser(
            sprintf('%s\'s project', $providerUser->getNickname()),
            $providerUser->getName(),
            $providerUser->getEmail(),
            $password = Str::random(12)
        ))->register();

        $user->sourceProviders()->updateOrCreate([
            'type' => $provider,
            'provider_user_id' => $providerUser->getId(),
        ], [
            'access_token' => $providerUser->token,
            'name' => trans('auth.provider.'.$provider),
        ]);

        auth()->loginUsingId($user->id);

        event(new Registered($provider, $user, $password));

        return redirect()->to('/account');
    }

    /**
     * Get required scopes
     *
     * @param string $provider
     *
     * @return array
     */
    public function getScopes(string $provider): array
    {
        return $this->getProviderConfig($provider)['scopes'] ?? [];
    }

    /**
     * @param string $provider
     * @return array
     */
    protected function getProviderConfig(string $provider): array
    {
        $config = $this->getConfig()->get($provider);

        if (!$config) {
            abort(404);
        }

        return $config;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getConfig(): \Illuminate\Support\Collection
    {
        return collect(config('source_providers', []))->keyBy('type');
    }
}