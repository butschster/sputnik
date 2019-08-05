<?php

Route::middleware('auth:api')->group(function () {

    Route::get('servers', 'ServerController@index')->name('servers');
    Route::get('server/{server}', 'ServerController@show')->name('server.show');
    Route::post('server', 'ServerController@store')->name('server.store');

});
