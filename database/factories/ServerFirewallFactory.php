<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use App\Models\Server\Firewall\Rule;
use Faker\Generator as Faker;

$factory->define(Rule::class, function (Faker $faker) {
    return [
        'server_id' => factory(Server::class),
        'editable' => $faker->boolean(90),
        'name' => $faker->word,
        'port' => $faker->numberBetween(22, 65331),
        'protocol' => $faker->randomElement(['tcp', 'udp', null]),
        'from' => $faker->ipv4,
        'policy' => $faker->randomElement(['allow', 'deny']),
    ];
});
