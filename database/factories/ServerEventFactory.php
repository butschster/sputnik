<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use Faker\Generator as Faker;

$factory->define(Server\Event::class, function (Faker $faker) {
    return [
        'server_id' => factory(Server::class),
        'message' => $faker->paragraph,
    ];
});
