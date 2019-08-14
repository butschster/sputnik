<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\User\SourceProvider;
use Illuminate\Http\Request;
use Socialite;
use App\Http\Controllers\Controller;

class BitbucketLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('bitbucket')->setScopes([])->redirect();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request)
    {
        $bitbucketUser = Socialite::driver('bitbucket')->user();

        if (auth()->check()) {
            /** @var User $user */
            $user = $request->user();
        } else {
            $provider = SourceProvider::where('provider_user_id', $bitbucketUser->getId())->firstOrFail();
            $user = $provider->user;
            auth()->loginUsingId($provider->user_id);
        }

        $user->sourceProviders()->updateOrCreate([
            'type' => 'bitbucket',
            'provider_user_id' => $bitbucketUser->getId(),
        ], [
            'access_token' => $bitbucketUser->token,
            'name' => 'Bitbucket',
        ]);

        return redirect()->route('user.profile');
    }
}
