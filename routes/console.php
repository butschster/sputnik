<?php

use App\Events\Server\Configured;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('server:configure {server}', function (\App\Services\Server\ConfiguratorService $service, $server) {

    $server = \App\Models\Server::findOrFail($server);

    $service->configure($server);

})->describe('Run server configurator');

Artisan::command('server:configured {server}', function ($server) {
    $server = \App\Models\Server::findOrFail($server);

    event(new Configured($server));

})->describe('Fire event about server configured');

Artisan::command('firewall:disable {id}', function ($id) {
    $rule = \App\Models\Server\Firewall\Rule::findOrFail($id);

    $rule->delete();

})->describe('Disable firewall rule');


Artisan::command('server:sync-keys {server}', function ($server) {

    $server = \App\Models\Server::findOrFail($server);

    foreach ($server->keys as $key) {
        app(\App\Listeners\Server\AddPublicKeyToServer::class)->handle(
            new \App\Events\Server\Key\AttachedToServer($server, $key)
        );
    }

})->describe('Sync ssh keys');
