<?php

Route::get('/server/{server}/install', 'ServerInstallerController')->name('server.install_script');
Route::any('/callback', 'CallbackController')->name('callback');

Auth::routes();

Route::get('login/github', 'Auth\GithubLoginController@redirectToProvider')->name('login.github');
Route::get('login/github/callback', 'Auth\GithubLoginController@handleProviderCallback')->name('login.github.callback');

Route::get('login/bitbucket', 'Auth\BitbucketLoginController@redirectToProvider')->name('login.bitbucket');
Route::get('login/bitbucket/callback', 'Auth\BitbucketLoginController@handleProviderCallback')->name('login.bitbucket.callback');

Route::middleware('auth')->group(function () {
    Route::get('profile/team/{team}', 'UserTeamController@show')->name('team.show');
    Route::get('profile', 'UserController@profile')->name('user.profile');
    Route::post('team/{team}/subscribe', 'UserTeamController@subscribe')->name('team.subscribe');
    Route::post('team/{team}/subscription/renew', 'UserTeamController@renew')->name('team.subscription.renew');

    Route::middleware('has-subscription')->group(function () {
        Route::delete('team/{team}/subscription/cancel', 'UserController@cancelSubscription')->name('user.subscription.cancel');

        Route::get('/server/{server}', 'ServerController@show')->name('server.show');
        Route::get('/server/{server}/config', 'ServerController@config')->name('server.config');
        Route::post('/server', 'ServerController@store')->name('server.store');
        Route::delete('/server/{server}', 'ServerController@delete')->name('server.delete');
        Route::get('/task/{task}', 'TasksController@show')->name('task.show');
        Route::get('/', 'ServerController@index')->name('home');


        Route::get('/server/{server}/scheduler', 'ServerSchedulerController@index')->name('server.scheduler.index');
        Route::post('/server/{server}/job', 'ServerSchedulerController@store')->name('server.scheduler.store');

        Route::get('/server/{server}/firewall', 'ServerFirewallController@index')->name('server.firewall.index');
        Route::post('/server/{server}/firewall', 'ServerFirewallController@store')->name('server.firewall.store');


        Route::get('/server/{server}/users', 'ServerUsersController@index')->name('server.user.index');
        Route::post('/server/{server}/user', 'ServerUsersController@store')->name('server.user.store');
        Route::delete('/server/{server}/user/{user}', 'ServerUsersController@delete')->name('server.user.delete');
        Route::get('/server/{server}/user/{user}/download', 'ServerUsersController@downloadPrivateKey')->name('server.user.download');

        Route::get('/server/{server}/site/{site}', 'ServerSitesController@show')->name('server.site.show');
        Route::post('/server/{server}/site', 'ServerSitesController@store')->name('server.site.store');
        Route::delete('/server/site/{site}', 'ServerSitesController@delete')->name('server.site.delete');

        Route::get('/server/{server}/site/{site}/deployments', 'ServerSitesController@deployments')->name('server.site.deployments.index');
        Route::post('/server/{server}/site/{site}/deploy', 'ServerSitesController@deploy')->name('server.site.deploy');
        Route::get('/server/{server}/site/{site}/deploy/config', 'ServerSitesController@deployConfig')->name('server.site.deploy.config');

        Route::post('/server/{server}/site/{site}/repository', 'ServerSitesRepositoryController@update')->name('server.site.repository.update');
        Route::post('/server/{server}/site/{site}/repository/add-key', 'ServerSitesRepositoryController@registerKey')->name('server.site.repository.add_key');
        Route::post('/server/{server}/site/{site}/repository/add-webhook', 'ServerSitesRepositoryController@registerWebhook')->name('server.site.repository.add_webhook');

        Route::get('/server/{server}/site/{site}/environment', 'ServerSiteEnvironmentController@index')->name('server.site.environment.index');
        Route::post('/server/{server}/site/{site}/environment', 'ServerSiteEnvironmentController@update')->name('server.site.environment.update');
        Route::delete('/server/{server}/site/{site}/environment', 'ServerSiteEnvironmentController@delete')->name('server.site.environment.delete');
        Route::post('/server/{server}/site/{site}/environment/upload', 'ServerSiteEnvironmentController@upload')->name('server.site.environment.upload');

        Route::get('/server/{server}/database', 'ServerDatabaseController@index')->name('server.database.index');
        Route::post('/server/{server}/database', 'ServerDatabaseController@store')->name('server.database.store');
        Route::delete('/server/{server}/database/{database}', 'ServerDatabaseController@delete')->name('server.database.delete');

        Route::get('/server/{server}/supervisor', 'ServerSupervisorController@index')->name('server.supervisor.index');
        Route::post('/server/{server}/supervisor', 'ServerSupervisorController@store')->name('server.supervisor.store');
        Route::delete('/server/{server}/supervisor/{daemon}', 'ServerSupervisorController@delete')->name('server.supervisor.delete');
    });
});
