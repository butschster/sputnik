<?php

use App\Http\Resources\v1\UserProfileResource;

Route::get('/server/{server}/install', 'ServerInstallerController')->name('server.install_script');
Route::any('/callback', 'CallbackController')->name('callback');

Auth::routes();

Route::get('login/github', 'Auth\GithubLoginController@redirectToProvider')->name('login.github');
Route::get('login/github/callback', 'Auth\GithubLoginController@handleProviderCallback')->name('login.github.callback');

Route::get('login/bitbucket', 'Auth\BitbucketLoginController@redirectToProvider')->name('login.bitbucket');
Route::get('login/bitbucket/callback', 'Auth\BitbucketLoginController@handleProviderCallback')->name('login.bitbucket.callback');

Route::middleware('auth')->group(function () {

    Route::any('{vue?}', function (\Illuminate\Http\Request $request, \App\Contracts\Modules\ManagerInterface $manager) {
        return view('app', [
            'user' => UserProfileResource::make($request->user()),
            'modules' => $manager->getModules()->map->getName()
        ]);
    })->where('vue', '^(?!api)[\/\w\.-]*$')->name('app');

});