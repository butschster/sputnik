<?php

Route::middleware('auth:api')->group(function () {

    // Servers
    Route::get('servers', 'ServerController@index')->name('servers');
    Route::get('server/{server}', 'ServerController@show')->name('server.show');
    Route::post('server', 'ServerController@store')->name('server.store');

    // Public keys
    Route::post('server/{server}/key', 'Server\PublicKeysController@store')->name('server.key.store');
    Route::delete('server/key/{key}', 'Server\PublicKeysController@delete')->name('server.key.delete');

    // Cron jobs
    Route::post('server/{server}/cron', 'Server\CronJobsController@store')->name('server.cron_job.store');
    Route::delete('server/cron/{job}', 'Server\CronJobsController@delete')->name('server.cron_job.delete');
});
