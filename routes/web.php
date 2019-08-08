<?php

Route::post('/callback', 'CallbackController')->name('callback');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/server/{server}', 'ServerController@show')->name('server.show');
    Route::get('/server/{server}/config', 'ServerController@config')->name('server.config');
    Route::post('/server', 'ServerController@store')->name('server.store');
    Route::get('/task/{task}', 'TasksController@show')->name('task.show');
    Route::get('/', 'ServerController@index')->name('home');


    Route::post('/server/{server}/job', 'ServerSchedulerController@store')->name('server.scheduler.store');
    Route::post('/server/{server}/firewall', 'ServerFirewallController@store')->name('server.firewall.store');
    Route::post('/server/{server}/key', 'ServerPublicKeyController@store')->name('server.public_key.store');
});

Route::get('/server/{server}/install', 'ServerController@installationScript')->name('server.install_script');
