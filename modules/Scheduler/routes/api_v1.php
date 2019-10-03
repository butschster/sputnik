<?php

Route::middleware('auth')->group(function () {

    Route::middleware('has-subscription')->group(function () {
        // Server Cron jobs
        Route::get('server/{server}/cron', 'SchedulerController@index')->name('server.cron_jobs');
        Route::post('server/{server}/cron', 'SchedulerController@store')->name('server.cron_job.store');
        Route::get('server/cron/{job}', 'SchedulerController@show')->name('server.cron_job.show');
        Route::delete('server/cron/{job}', 'SchedulerController@delete')->name('server.cron_job.delete');
    });
});
