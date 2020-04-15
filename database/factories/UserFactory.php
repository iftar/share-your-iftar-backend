<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $faker = Factory::create('en_GB');

    return [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'email'             => customEmail(),
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'type'              => 'user',
        'status'            => 'approved',
    ];
});

$factory->state(User::class, 'charity', function ($faker) {
    return [
        'type' => 'charity',
    ];
});

$factory->state(User::class, 'collection-point', function ($faker) {
    return [
        'type' => 'collection-point',
    ];
});

function customEmail()
{
    $faker = Factory::create('en_GB');

    return strtolower(
        "$faker->firstName.$faker->firstName.$faker->lastName" . $faker->numberBetween(1, 1000) . "@$faker->domainName"
    );
}
