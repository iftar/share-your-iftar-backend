<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Charity;
use Faker\Generator as Faker;
use App\Models\CollectionPoint;
use App\Models\CharityCollectionPoint;

$factory->define(CharityCollectionPoint::class, function (Faker $faker, $options) {

    $charity = array_key_exists('charity_id', $options)
        ? Charity::find($options['charity_id'])
        : factory(Charity::class)->create();

    $collectionPoint = array_key_exists('collection_point_id', $options)
        ? CollectionPoint::find($options['collection_point_id'])
        : factory(CollectionPoint::class)->create();

    return [
        'charity_id'          => $charity->id,
        'collection_point_id' => $collectionPoint->id,
    ];
});
