<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User\SourceProvider;
use Faker\Generator as Faker;

$factory->define(SourceProvider::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\Models\User::class),
        'name' => $faker->word,
        'type' => $faker->randomElement(['github', 'bitbucket']),
        'access_token' => $faker->sha1,
        'provider_user_id' => $faker->bankAccountNumber
    ];
});
