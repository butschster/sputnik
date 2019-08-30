<?php

Route::get('subscription/plans', 'SubscriptionController@plans')->name('subscription.plans');

// Source providers
Route::get('source-providers', 'User\SourceProvidersController@available')->name('source_providers');

Route::middleware('auth')->group(function () {

    // User
    Route::get('profile', 'UserController@profile')->name('user.profile');
    Route::get('profile/source-providers', 'User\SourceProvidersController@connected')->name('user.source_providers');
    Route::delete('profile', 'UserController@delete')->name('user.delete');

    // Team
    Route::get('profile/teams', 'User\TeamController@show')->name('teams');
    Route::get('profile/team/{team}', 'User\TeamController@show')->name('team.show');
    Route::get('profile/team/{team}/members', 'User\Team\MembersController@index')->name('team.members');

    // Subscription
    Route::delete('profile/team/{team}/cancel-subscription', 'SubscriptionController@cancel')->name('team.subscription.cancel');
    Route::post('profile/team/{team}/subscribe/{plan}', 'SubscriptionController@subscribe')->name('team.subscribe');

    Route::middleware('has-subscription')->group(function () {
        // Servers
        Route::get('servers', 'ServerController@index')->name('servers');
        Route::get('server/{server}', 'ServerController@show')->name('server.show');
        Route::put('server/{server}', 'ServerController@update')->name('server.update');
        Route::post('server', 'ServerController@store')->name('server.store');
        Route::delete('server/{server}', 'ServerController@delete')->name('server.delete');

        // Events
        Route::get('server/{server}/events', 'Server\EventsController@index')->name('server.events');
        Route::get('server/{server}/last-event', 'Server\EventsController@last')->name('server.event.last');

        // Cron jobs
        Route::get('server/{server}/cron', 'Server\SchedulerController@index')->name('server.cron_job.index');
        Route::post('server/{server}/cron', 'Server\SchedulerController@store')->name('server.cron_job.store');
        Route::get('server/cron/{job}', 'Server\SchedulerController@show')->name('server.cron_job.show');
        Route::delete('server/cron/{job}', 'Server\SchedulerController@delete')->name('server.cron_job.delete');

        // Database
        Route::get('server/{server}/databases', 'Server\DatabaseController@index')->name('server.database.index');
        Route::post('server/{server}/database', 'Server\DatabaseController@store')->name('server.database.store');
        Route::get('server/database/{database}', 'Server\DatabaseController@show')->name('server.database.show');
        Route::delete('server/database/{database}', 'Server\DatabaseController@delete')->name('server.database.delete');

        // Firewall
        Route::get('server/{server}/firewall/rules', 'Server\FirewallController@index')->name('server.firewall.index');
        Route::post('server/{server}/firewall', 'Server\FirewallController@store')->name('server.firewall.store');
        Route::get('server/firewall/{rule}', 'Server\FirewallController@show')->name('server.firewall.show');
        Route::delete('server/firewall/{rule}', 'Server\FirewallController@delete')->name('server.firewall.delete');

        // Server users
        Route::get('server/{server}/users', 'Server\UserController@index')->name('server.users');
        Route::post('server/{server}/user', 'Server\UserController@store')->name('server.user.store');
        Route::get('server/user/{user}', 'Server\UserController@show')->name('server.user.show');
        Route::delete('server/user/{user}', 'Server\UserController@delete')->name('server.user.delete');

        // Server tasks
        Route::get('server/{server}/tasks', 'Server\TasksController@index')->name('server.tasks');
        Route::get('server/task/{task}', 'Server\TasksController@show')->name('server.task.show');
        Route::delete('server/task/{task}', 'Server\TasksController@delete')->name('server.task.delete');

        // Supervisor
        Route::get('server/{server}/supervisor/list', 'Server\SupervisorController@index')->name('server.supervisor.index');
        Route::post('server/{server}/supervisor/daemon', 'Server\SupervisorController@store')->name('server.supervisor.store');
        Route::get('server/supervisor/{daemon}', 'Server\SupervisorController@show')->name('server.supervisor.show');
        Route::delete('server/supervisor/{daemon}', 'Server\SupervisorController@delete')->name('server.supervisor.delete');

        // Site
        Route::get('/server/{server}/sites', 'Server\SiteController@index')->name('server.sites');
        Route::get('/server/site/{site}', 'Server\SiteController@show')->name('server.site.show');
        Route::post('/server/{server}/site', 'Server\SiteController@store')->name('server.site.store');
        Route::delete('/server/site/{site}', 'Server\SiteController@delete')->name('server.site.delete');

        // Site deployment
        Route::get('/server/site/{site}/deploy/config', 'Server\Site\DeploymentsController@config')->name('server.site.deploy.config');
        Route::post('/server/site/{site}/deploy', 'Server\Site\DeploymentsController@deploy')->name('server.site.deploy');

        // Site environment
        Route::post('/server/site/{site}/environment/upload', 'Server\Site\EnvironmentController@upload')->name('server.site.environment.upload');
        Route::post('/server/site/{site}/environment', 'Server\Site\EnvironmentController@update')->name('server.site.environment.update');
        Route::delete('/server/site/{site}/environment', 'Server\Site\EnvironmentController@delete')->name('server.site.environment.delete');

        // Site repository
        Route::post('/server/site/{site}/repository/sync-remote', 'Server\Site\RepositoryController@syncRemote')->name('server.site.repository.sync');
        Route::post('/server/site/{site}/repository', 'Server\Site\RepositoryController@update')->name('server.site.repository.update');
    });
});
