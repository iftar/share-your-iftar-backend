<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CollectionPoint;
use Faker\Generator as Faker;
use Faker\Factory;

$factory->define(CollectionPoint::class, function (Faker $faker) {
    $faker = Factory::create('en_GB');

    return [
        'name'               => $faker->company,
        'address_line_1'     => $faker->streetAddress,
        'address_line_2'     => $faker->streetName,
        'city'               => $faker->city,
        'county'             => $faker->county,
        'post_code'          => $faker->postcode,
        'max_daily_capacity' => rand(10, 200),
    ];
});
