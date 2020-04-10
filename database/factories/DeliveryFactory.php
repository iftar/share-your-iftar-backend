<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Delivery;
use App\Models\User;
use App\Models\Pickup;
use Faker\Generator as Faker;

$factory->define(Delivery::class, function (Faker $faker) {
    return [
        //
        'user_id' => function () {
            return factory(User::class)->states('charity')->create()->id;
        },
        'pickup_id' => function () {
            return factory(Pickup::class)->create()->id;
        },
        'notes' => $faker->paragraph(),
    ];
});
