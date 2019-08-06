<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Server::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'user_id' => factory(\App\Models\User::class),
        'name' => Str::random(10),
        'ip' => $faker->ipv4,
        'ssh_port' => 22,
        'sudo_password' => $faker->md5,
        'meta' => [],
        'php_version' => $faker->randomElement(['56', '70', '71', '72', '73']),
        'database_type' => $faker->randomElement(['mariadb', 'mysql', 'mysql8', 'pgsql']),
        'database_password' => $faker->md5
    ];
});