<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\User\SourceProvider;
use Illuminate\Http\Request;
use Socialite;
use App\Http\Controllers\Controller;

class GithubLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')
            ->setScopes(['repo', 'write:public_key', 'read:public_key', 'admin:repo_hook'])
            ->redirect();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request)
    {
        $githubUser = Socialite::driver('github')->user();

        if (auth()->check()) {
            /** @var User $user */
            $user = $request->user();
        } else {
            $provider = SourceProvider::where('provider_user_id', $githubUser->getId())->firstOrFail();
            $user = $provider->user;
            auth()->loginUsingId($provider->user_id);
        }

        $user->sourceProviders()->updateOrCreate([
            'type' => 'github',
            'provider_user_id' => $githubUser->getId(),
        ], [
            'access_token' => $githubUser->token,
            'name' => 'Github',
        ]);

        return redirect()->to('/account');
    }
}
