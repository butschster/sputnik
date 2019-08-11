<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Server\Site;
use App\Models\Server\Site\Deployment;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Deployment::class, function (Faker $faker) {
    return [
        'server_site_id' => factory(Site::class),
        'initiator_id' => factory(User::class),
        'branch' => 'master',
        'commit_hash' => $faker->sha1,
    ];
});
