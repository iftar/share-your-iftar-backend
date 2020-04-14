<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Charity;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Charity::class, function (Faker $faker) {
    $faker = Factory::create('en_GB');

    return [
        'name' => $faker->company,
        'charity_registration_number' => $faker->uuid,
        'max_delivery_capacity' => rand(5,30),
    ];
});
