<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Delivery;
use App\Models\Order;
use App\Models\Pickup;
use App\Models\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        //
        'order_id' => function () {
            return factory(Order::class)->create()->id;
        },
        'pickup_id' => function () {
            return factory(Pickup::class)->create()->id;
        },
        'delivery_id' => function () {
            return factory(Delivery::class)->create()->id;
        },
        'status' => 'awaiting_acceptance' 
    ];
});
