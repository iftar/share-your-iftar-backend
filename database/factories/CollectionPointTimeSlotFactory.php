<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use Faker\Generator as Faker;
use App\Models\CollectionPoint;
use App\Models\CollectionPointTimeSlot;

$factory->define(CollectionPointTimeSlot::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $collectionPoint = array_key_exists('collection_point_id', $options)
        ? CollectionPoint::find($options['collection_point_id'])
        : factory(CollectionPoint::class)->create();

    return [
        'collection_point_id' => $collectionPoint->id,
        'start_time'          => '18:00',
        'end_time'            => '18:15',
        'max_capacity'        => $faker->numberBetween(1, 10),
        'type'                => 'user_pickup',
    ];
});

$factory->state(CollectionPointTimeSlot::class, 'charity-pickup', function ($faker) {
    return [
        'type' => 'charity_pickup',
    ];
});
