<?php

Route::middleware('auth')->group(function () {

    Route::middleware('has-subscription')->group(function () {

        // WebServer Supervisor
        Route::get('server/{server}/supervisor/list', 'SupervisorController@index')->name('server.supervisors');
        Route::post('server/{server}/supervisor/daemon', 'SupervisorController@store')->name('server.supervisor.store');
        Route::post('server/{server}/supervisor/restart', 'SupervisorController@restart')->name('server.supervisor.restart');
        Route::get('server/supervisor/{daemon}', 'SupervisorController@show')->name('server.supervisor.show');
        Route::delete('server/supervisor/{daemon}', 'SupervisorController@delete')->name('server.supervisor.delete');

    });

});
