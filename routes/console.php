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

Artisan::command('server:firewall:rules {id}', function (\App\Services\Server\FirewallService $service, $id) {
    $server = \App\Models\Server::findOrFail($id);
    $rules = $service->getAvailableRules($server);


    $headers = ['Port', 'Action', 'From', 'Version'];

    $this->info('Remove rules');
    $this->table($headers, $rules->map(function(\App\Utils\SSH\ValueObjects\UfwRule $rule) {
        return [
            $rule->port(),
            $rule->policy(),
            $rule->from(),
            $rule->getVersion()
        ];
    }));

    $this->info('Database rules');
    $this->table($headers, $server->firewallRules->map(function(\App\Utils\SSH\Contracts\UfwRule $rule) {
        return [
            $rule->port(),
            $rule->policy(),
            $rule->from(),
            'v4'
        ];
    }));
})->describe('Show server firewall rules');

Artisan::command('server:firewall:disable {id}', function ($id) {
    $rule = \App\Models\Server\Firewall\Rule::findOrFail($id);
    $rule->delete();
})->describe('Disable firewall rule');

Artisan::command('server:firewall:create-random {id}', function ($id) {
    $server = \App\Models\Server::findOrFail($id);
    $rule = factory(\App\Models\Server\Firewall\Rule::class)->create([
        'server_id' => $server->id
    ]);

    $this->info('Firewall rule created '. $rule->id);
})->describe('Create random firewall rule');

Artisan::command('server:cron:create-random {id}', function ($id) {
    $server = \App\Models\Server::findOrFail($id);
    $job = factory(\App\Models\Server\CronJob::class)->create([
        'server_id' => $server->id
    ]);

    $this->info('Job created '. $job->id);
})->describe('Create random cron job');

Artisan::command('server:cron:delete {id}', function ($id) {
    $job = \App\Models\Server\CronJob::findOrFail($id);
    $job->delete();
})->describe('Disable cron job');

Artisan::command('server:sync-keys {server}', function ($server) {

    $server = \App\Models\Server::findOrFail($server);

    foreach ($server->keys as $key) {
        app(\App\Listeners\Server\AddPublicKeyToServer::class)->handle(
            new \App\Events\Server\Key\AttachedToServer($server, $key)
        );
    }

})->describe('Sync ssh keys');
