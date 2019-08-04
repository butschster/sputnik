<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use App\Models\Server\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $user = $faker->randomElement(['root', 'nginx', 'php', 'mysql']);

    return [
        'server_id' => factory(Server::class),
        'name' => 'Run ' . $faker->uuid . ' script for ' . $user,
        'user' => $user,
        'script' => 'echo "Hello world"',
        'options' => ['timeout' => 60],
    ];
});
