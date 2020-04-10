<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Pickup;
use App\Models\User;
use Faker\Generator as Faker;
use Faker\Factory;

$factory->define(Pickup::class, function (Faker $faker) {
    $faker = Factory::create('en_GB');
    $order = factory(Order::class)->create();
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'order_id' => function () use($order) {
            return $order->id;
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
        'notes' => $faker->paragraph(),
        'pickup_at' => $order->required_at->setTime(rand(16,18), rand(0, 59)),
    ];
});
