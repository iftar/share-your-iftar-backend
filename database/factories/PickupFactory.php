<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use App\Models\Order;
use App\Models\Pickup;
use Faker\Generator as Faker;

$factory->define(Pickup::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->create();

    $order = array_key_exists('order_id', $options)
        ? Order::find($options['order_id'])
        : factory(Order::class)->create();

    return [
        'user_id'        => $user->id,
        'order_id'       => $order->id,
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $faker->e164PhoneNumber,
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $faker->streetName,
        'town'           => $faker->city,
        'county'         => $faker->county,
        'post_code'      => $faker->postcode,
        'notes'          => $faker->paragraph,
        'pickup_at'      => $order->required_at->setTime(rand(16, 18), rand(0, 59)),
    ];
});
