<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BatchOrder;
use App\Models\Batch;
use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(BatchOrder::class, function (Faker $faker, $options) {
    $batch = array_key_exists('batch_id', $options)
        ? Batch::find($options['batch_id'])
        : factory(Batch::class)->create();

    $order = array_key_exists('order_id', $options)
        ? Order::find($options['order_id'])
        : factory(Order::class)->create();

    return [
        'batch_id' => $batch->id,
        'order_id' => $order->id,
    ];
});
