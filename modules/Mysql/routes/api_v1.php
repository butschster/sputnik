<?php

Route::middleware('auth')->group(function () {

    Route::middleware('has-subscription')->group(function () {

        // WebServer Database
        Route::get('server/{server}/databases', 'DatabaseController@index')->name('server.databases');
        Route::post('server/{server}/database', 'DatabaseController@store')->name('server.database.store');
        Route::get('server/database/{database}', 'DatabaseController@show')->name('server.database.show');
        Route::delete('server/database/{database}', 'DatabaseController@delete')->name('server.database.delete');

    });
});
