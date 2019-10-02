<?php

Route::middleware('auth')->group(function () {

    Route::middleware('has-subscription')->group(function () {

        // OpenVPN clients
        Route::get('server/{server}/openvpn/clients', 'ClientsController@index')->name('server.openvpn.clients');
        Route::post('server/{server}/openvpn/client', 'ClientsController@store')->name('server.openvpn.client.store');
        Route::get('server/openvpn/client/{client}/download', 'ClientsController@download')->name('server.openvpn.client.download');
        Route::delete('server/openvpn/{client}', 'ClientsController@delete')->name('server.openvpn.client.delete');

    });
});
