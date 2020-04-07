<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use Faker\Factory;

$factory->define(Order::class, function (Faker $faker) {
    $faker = Factory::create('en_GB');

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $faker->streetName,
        'town' => $faker->city,
        'county' => $faker->county,
        'post_code' => $faker->postcode,
        'date_requested' => now()
    ];
});
