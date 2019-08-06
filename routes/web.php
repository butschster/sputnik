<?php

Route::post('/callback', 'CallbackController')->name('callback'); //->middleware('signed');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/server/{server}', 'ServerController@show')->name('server.show');
    Route::get('/task/{task}', 'TasksController@show')->name('task.show');
    Route::get('/', 'ServerController@index')->name('home');
});

Route::get('/server/{server}/install', 'ServerController@installationScript')->name('server.install_script');

