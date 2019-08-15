<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server\User\PublicKey;
use Faker\Generator as Faker;

$factory->define(PublicKey::class, function (Faker $faker) {
    return [
        'server_id' => factory(\App\Models\Server\User::class),
        'name' => $faker->word,
        'key' => $faker->paragraph
    ];
});
