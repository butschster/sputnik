<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server\Key;
use Faker\Generator as Faker;

$factory->define(Key::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'content' => $faker->paragraph
    ];
});
