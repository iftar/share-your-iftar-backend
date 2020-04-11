<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Pickup;
use App\Models\Status;
use App\Models\Delivery;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $order = array_key_exists('order_id', $options)
        ? Order::find($options['order_id'])
        : factory(Order::class)->create();

    $pickup = array_key_exists('pickup_id', $options)
        ? Pickup::find($options['pickup_id'])
        : factory(Pickup::class)->create();

    $delivery = array_key_exists('delivery_id', $options)
        ? Delivery::find($options['delivery_id'])
        : factory(Delivery::class)->create();

    return [
        'order_id'    => $order->id,
        'pickup_id'   => $pickup ? $pickup->id : null,
        'delivery_id' => $delivery ? $delivery->id : null,
        'status'      => 'awaiting_acceptance'
    ];
});
