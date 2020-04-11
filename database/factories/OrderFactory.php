<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->create();

    return [
        'user_id'        => $user->id,
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $faker->e164PhoneNumber,
        'address_line_1' => $faker->streetAddress,
        'address_line_2' => $faker->streetName,
        'town'           => $faker->city,
        'county'         => $faker->county,
        'post_code'      => $faker->postcode,
        'quantity_child' => rand(0, 5),
        'quantity_adult' => rand(0, 5),
        'notes'          => $faker->paragraph,
        'required_at'    => $faker->dateTimeBetween('+1 day', '+7 days'),
    ];
});
