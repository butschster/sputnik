<?php

Route::get('subscription/plans', 'SubscriptionController@plans')->name('subscription.plans');

// Source providers
Route::get('source-providers', 'User\SourceProvidersController@available')->name('source_providers');

Route::middleware('auth')->group(function () {

    // User
    Route::get('profile', 'UserController@profile')->name('user.profile');
    Route::put('profile', 'UserController@update')->name('user.profile.update');
    Route::delete('profile', 'UserController@delete')->name('profile.delete');

    // Scripts
    Route::get('scripts', 'ScriptsController@public')->name('scripts.public');
    Route::get('profile/scripts', 'ScriptsController@index')->name('profile.scripts');
    Route::post('profile/script', 'ScriptsController@store')->name('script.store');
    Route::get('script/{script}', 'ScriptsController@show')->name('script.show');
    Route::put('script/{script}', 'ScriptsController@update')->name('script.update');
    Route::delete('scripts/{script}', 'ScriptsController@delete')->name('script.delete');
    Route::post('scripts/{script}/execute', 'ScriptsController@execute')->name('script.execute');

    Route::get('profile/source-providers', 'User\SourceProvidersController@connected')->name('profile.source_providers');
    Route::delete('profile/source-provider/{provider}/unlink', 'User\SourceProvidersController@unlink')->name('profile.source_provider.unlink');

    // User notifications
    Route::get('profile/notifications', 'User\NotificationController@recent')->name('profile.notifications');
    Route::delete('profile/notification', 'User\NotificationController@markAsRead')->name('profile.notifications.read');

    // Team
    Route::get('profile/teams', 'User\TeamController@index')->name('profile.teams');
    Route::get('team/{team}', 'User\TeamController@show')->name('team.show');
    Route::get('team/{team}/members', 'User\Team\MembersController@index')->name('team.members');

    Route::get('team/{team}/payment/methods', 'User\Team\PaymentMethodsController@paymentMethods')->name('team.payment.methods');
    Route::post('team/{team}/payment/intention', 'User\Team\PaymentMethodsController@createIntenttion')->name('team.payment.method.intent');
    Route::post('team/{team}/payment/method', 'User\Team\PaymentMethodsController@store')->name('team.payment.method.store');
    Route::delete('team/{team}/payment/method/{id}', 'User\Team\PaymentMethodsController@delete')->name('team.payment.method.delete');

    // Subscription
    Route::delete('team/{team}/cancel-subscription', 'SubscriptionController@cancel')->name('team.subscription.cancel');
    Route::post('team/{team}/resume-subscription', 'SubscriptionController@resume')->name('team.subscription.resume');
    Route::post('team/{team}/subscribe/{plan}', 'SubscriptionController@subscribe')->name('team.subscribe');

    Route::middleware(['has-subscription', /* 'verified' */])->group(function () {

        // Servers
        Route::get('servers/search', 'ServerController@search')->name('servers.search');
        Route::get('servers', 'ServerController@index')->name('servers');
        Route::get('server/{server}', 'ServerController@show')->name('server.show');
        Route::get('server/{server}/install-script', 'ServerController@installScript')->name('server.install_script');
        Route::put('server/{server}', 'ServerController@update')->name('server.update');
        Route::post('server', 'ServerController@store')->name('server.store');
        Route::delete('server/{server}', 'ServerController@delete')->name('server.delete');

        // Server modules
        Route::get('servers/modules', 'Server\ModulesController@index')->name('servers.modules');
        Route::get('server/{server}/modules', 'Server\ModulesController@installed')->name('server.modules');
        Route::get('server/{server}/module/{module}/{action}', 'Server\ModulesController@script')->name('server.module.action.script');

        // Server Events
        Route::get('server/{server}/events', 'Server\EventsController@index')->name('server.events');
        Route::get('server/{server}/last-event', 'Server\EventsController@last')->name('server.event.last');

        // Server Firewall
        Route::post('server/{server}/firewall/enable', 'Server\FirewallController@enable')->name('server.firewall.enable');
        Route::post('server/{server}/firewall/disable', 'Server\FirewallController@disable')->name('server.firewall.disable');
        Route::get('server/{server}/firewall/rules', 'Server\FirewallController@index')->name('server.firewall.rules');
        Route::post('server/{server}/firewall', 'Server\FirewallController@store')->name('server.firewall.store');
        Route::get('server/firewall/{rule}', 'Server\FirewallController@show')->name('server.firewall.show');
        Route::delete('server/firewall/{rule}', 'Server\FirewallController@delete')->name('server.firewall.delete');

        // Server users
        Route::get('server/{server}/users', 'Server\UserController@index')->name('server.users');
        Route::post('server/{server}/user', 'Server\UserController@store')->name('server.user.store');
        Route::get('server/user/{user}', 'Server\UserController@show')->name('server.user.show');
        Route::get('server/user/{user}/download', 'Server\UserController@downloadPublicKey')->name('server.user.download_key');
        Route::delete('server/user/{user}', 'Server\UserController@delete')->name('server.user.delete');

        // Server tasks
        Route::get('server/{server}/tasks', 'Server\TasksController@index')->name('server.tasks');
        Route::get('server/task/{task}', 'Server\TasksController@show')->name('server.task.show');

        // WebServer Sites
        Route::get('sites/{server}/processors', 'Server\Site\ConfiguratorController@processors')->name('sites.processors');
        Route::get('sites/{server}/web-servers', 'Server\Site\ConfiguratorController@webServers')->name('sites.web_servers');

        Route::get('sites', 'Server\SiteController@all')->name('sites');
        Route::get('server/{server}/sites', 'Server\SiteController@index')->name('server.sites');
        Route::get('sites/search', 'Server\SiteController@search')->name('sites.search');
        Route::get('server/site/{site}', 'Server\SiteController@show')->name('server.site.show');
        Route::post('server/{server}/site', 'Server\SiteController@store')->name('server.site.store');
        Route::delete('server/site/{site}', 'Server\SiteController@delete')->name('server.site.delete');

        // WebServer Site deployment
        Route::get('/server/site/{site}/deploy/config', 'Server\DeploymentsController@config')->name('server.site.deploy.config');
        Route::get('/server/site/{site}/deployments', 'Server\DeploymentsController@index')->name('server.site.deployments');
        Route::post('/server/site/{site}/deploy', 'Server\DeploymentsController@deploy')->name('server.site.deploy');

        // WebServer Site environment
        Route::get('/server/site/{site}/environment', 'Server\Site\EnvironmentController@index')->name('server.site.environment');
        Route::post('/server/site/{site}/environment/upload', 'Server\Site\EnvironmentController@upload')->name('server.site.environment.upload');
        Route::post('/server/site/{site}/environment', 'Server\Site\EnvironmentController@update')->name('server.site.environment.update');
        Route::delete('/server/site/{site}/environment', 'Server\Site\EnvironmentController@delete')->name('server.site.environment.delete');

        // WebServer Site repository
        Route::post('/server/site/{site}/repository/webhook', 'Server\Site\RepositoryController@registerWebhook')->name('server.site.repository.webhook');
        Route::post('/server/site/{site}/repository/public-key', 'Server\Site\RepositoryController@registerPublicKey')->name('server.site.repository.public_key');
        Route::post('/server/site/{site}/repository', 'Server\Site\RepositoryController@update')->name('server.site.repository.update');
    });
});
