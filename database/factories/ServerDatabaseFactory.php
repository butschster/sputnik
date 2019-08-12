<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use App\Models\Server\Database;
use Faker\Generator as Faker;

$factory->define(Database::class, function (Faker $faker) {
    return [
        'server_id' => factory(Server::class),
        'name' => $faker->word,
        'character_set' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ];
});
