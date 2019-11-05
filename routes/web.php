<?php

use App\Http\Resources\v1\UserProfileResource;

Route::get('/server/{server}/install', 'ServerInstallerController')->name('server.install_script');
Route::any('/callback', 'CallbackController')->name('callback');

Auth::routes();

Route::get('login/{provider}', 'Auth\ProviderLoginController@login')->name('provider.login');
Route::get('register/{provider}', 'Auth\ProviderLoginController@register')->name('provider.register');
Route::get('connect/{provider}', 'Auth\ProviderLoginController@connect')->name('provider.connect');

Route::get('login/{provider}/callback', 'Auth\ProviderLoginController@handleProviderCallback')->name('provider.callback');

Route::middleware('auth')->group(function () {

    Route::any('{vue?}', 'SpaController')->where('vue', '^(?!api)[\/\w\.-]*$')->name('app');

});