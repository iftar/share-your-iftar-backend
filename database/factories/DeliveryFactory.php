<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use App\Models\Pickup;
use App\Models\Delivery;
use Faker\Generator as Faker;

$factory->define(Delivery::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->create();

    $pickup = array_key_exists('pickup_id', $options)
        ? Pickup::find($options['pickup_id'])
        : factory(Pickup::class)->create();

    return [
        'user_id'   => $user->id,
        'pickup_id' => $pickup->id,
        'notes'     => $faker->paragraph,
    ];
});
