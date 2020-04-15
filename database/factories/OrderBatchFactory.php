<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderBatch;
use Faker\Generator as Faker;

$factory->define(OrderBatch::class, function (Faker $faker, $options) {
    return [
        'date' => $options['date'],
        'collection_point_id' => $options['collection_point_id'],
        'collection_time_slot_id' => $options['collection_time_slot_id'],
        'charity_id' => !empty($options['charity_id']) ? $options['charity_id'] : null,
    ];
});
