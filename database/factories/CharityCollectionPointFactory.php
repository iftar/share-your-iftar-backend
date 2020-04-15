<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CharityCollectionPoint;
use Faker\Generator as Faker;

$factory->define(CharityCollectionPoint::class, function (Faker $faker, $charity_id, $collection_point_id) {
    return [
        'charity_id' => $charity_id,
        'collection_point_id' => $collection_point_id,
    ];
});
