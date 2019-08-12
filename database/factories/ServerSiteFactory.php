<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server;
use App\Models\Server\Site;
use Faker\Generator as Faker;
use Dotenv\Dotenv;

$factory->define(Site::class, function (Faker $faker) {
    return [
        'server_id' => factory(Server::class),
        'domain' => $faker->domainName,
        'environment' => Dotenv::create(base_path('tests/fixtures'), 'env')->load(),
        'public_dir' => '/public',
        'repository' => 'SleepingOwlAdmin/sleepingowladmin.ru',
        'repository_provider' => 'github',
    ];
});
