<?php

Route::middleware('auth:api')->group(function () {

    // Servers
    Route::get('servers', 'ServerController@index')->name('servers');
    Route::get('server/{server}', 'ServerController@show')->name('server.show');
    Route::post('server', 'ServerController@store')->name('server.store');

    // Public keys
    Route::post('server/{server}/key', 'ServerKeysController@store')->name('server.key.store');
    Route::delete('server/key/{key}', 'ServerKeysController@delete')->name('server.key.delete');

    // Cron jobs
    Route::post('server/{server}/cron', 'ServerCronJobsController@store')->name('server.cron_job.store');
    Route::delete('server/cron/{job}', 'ServerCronJobsController@delete')->name('server.cron_job.delete');
});
