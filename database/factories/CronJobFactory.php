<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use App\Models\Server\CronJob;
use Faker\Generator as Faker;

$factory->define(CronJob::class, function (Faker $faker) {

    return [
        'server_id' => factory(Server::class),
        'name' => $faker->word,
        'cron' => $faker->randomElement(['* * * * *', '@daily', '@hourly', '@weekly', '@monthly', '@yearly']),
        'user' => $faker->randomElement(['root', 'user']),
        'command' => 'apt-get autoremove && apt-get autoclean',
    ];
});
