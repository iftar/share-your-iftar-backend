<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CollectionPoint;
use App\Models\CollectionPointUser;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(CollectionPointUser::class, function (Faker $faker, $options) {

    $collectionPoint = array_key_exists('collection_point_id', $options)
        ? CollectionPoint::find($options['collection_point_id'])
        : factory(CollectionPoint::class)->create();

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->state('collection-point')->create();

    return [
        'collection_point_id' => $collectionPoint->id,
        'user_id'             => $user->id,
    ];
});
