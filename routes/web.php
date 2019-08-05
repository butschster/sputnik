<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/server/{server}', 'ServerController@show')->name('server.show');
    Route::get('/task/{task}', 'TasksController@show')->name('task.show');
});

Route::get('/server/{server}/install', 'ServerController@installationScript')->name('server.install_script');

Route::post('/callback', 'CallbackController')->name('callback')->middleware('signed');
