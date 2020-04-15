<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CollectionPointTimeSlot;
use Faker\Generator as Faker;

$factory->define(CollectionPointTimeSlot::class, function (Faker $faker, $options) {
    return [
        'collection_point_id' => $options['collection_point_id'],
        'start_time' => $options['start_time'],
        'end_time' => $options['end_time'],
        'max_capacity' => $options['max_capacity'],
        'type' => $options['type'],
    ];
});
