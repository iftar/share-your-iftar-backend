<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\User;
use Faker\Generator as Faker;
use Faker\Factory;

$factory->define(Order::class, function (Faker $faker) {
    $faker = Factory::create('en_GB');

    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->e164PhoneNumber,
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $faker->streetName,
        'town' => $faker->city,
        'county' => $faker->county,
        'post_code' => $faker->postcode,
        'quantity_child' => rand(0,5),
        'quantity_adult' => rand(0,5),
        'notes' => $faker->paragraph(),
        'required_at' => now()->addDays(rand(1,7)),
    ];
});
