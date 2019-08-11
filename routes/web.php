<?php

Route::get('/server/{server}/install', 'ServerInstallerController')->name('server.install_script');
Route::any('/callback', 'CallbackController')->name('callback');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/server/{server}', 'ServerController@show')->name('server.show');
    Route::get('/server/{server}/config', 'ServerController@config')->name('server.config');
    Route::post('/server', 'ServerController@store')->name('server.store');
    Route::delete('/server/{server}', 'ServerController@delete')->name('server.delete');
    Route::get('/task/{task}', 'TasksController@show')->name('task.show');
    Route::get('/', 'ServerController@index')->name('home');


    Route::post('/server/{server}/job', 'ServerSchedulerController@store')->name('server.scheduler.store');
    Route::post('/server/{server}/firewall', 'ServerFirewallController@store')->name('server.firewall.store');
    Route::post('/server/{server}/key', 'ServerPublicKeyController@store')->name('server.public_key.store');

    Route::get('/server/{server}/site/{site}', 'ServerSitesController@show')->name('server.site.show');
    Route::post('/server/{server}/site', 'ServerSitesController@store')->name('server.site.store');
    Route::post('/server/{server}/site/{site}/repository', 'ServerSitesController@updateRepository')->name('server.site.update_repository');
    Route::delete('/server/site/{site}', 'ServerSitesController@delete')->name('server.site.delete');
    Route::post('/server/{server}/site/{site}/deploy', 'ServerSitesController@deploy')->name('server.site.deploy');
    Route::post('/server/{server}/site/{site}/environment', 'ServerSitesController@environment')->name('server.site.environment');
});
