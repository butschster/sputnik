<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use App\Models\Server\PublicKey;
use Faker\Generator as Faker;

$factory->define(PublicKey::class, function (Faker $faker) {
    return [
        'server_id' => factory(Server::class),
        'name' => $faker->word,
        'content' => $faker->paragraph
    ];
});
