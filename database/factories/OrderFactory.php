<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->create();

    /* $collectionPoint = array_key_exists('collection_point_id', $options)
        ? CollectionPoint::find($options['collection_point_id'])
        : factory(CollectionPoint::class)->create();
    
    $collectionTimeslotId = null;

    if ($option['type'] == "collection") {
        $collectionTimeslotId = array_key_exists('collection_timeslot_id', $options)
            ? CollectionTimeslot::find($options['collection_timeslot_id'])
            : factory(CollectionTimeslot::class)->create();
        $collectionTimeslotId = $collectionTimeslotId->id;
    } */



    return [
        'user_id'        => $user->id,
        'required_date'  => $faker->dateTimeBetween('+1 day', '+7 days'),
        'quantity'       => rand(0, 5),
        'collection_point_id' => 1, //$collectionPoint->id,
        'collection_timeslot_id' =>  1, //$collectionTimeslotId,
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $options['type'] == "delivery" ? $faker->e164PhoneNumber : null,
        'address_line_1' => $options['type'] == "delivery" ? $faker->streetAddress : null,
        'address_line_2' => $options['type'] == "delivery" ? $faker->streetName : null,
        'town'           => $options['type'] == "delivery" ? $faker->city : null,
        'county'         => $options['type'] == "delivery" ? $faker->county : null,
        'post_code'      => $options['type'] == "delivery" ? $faker->postcode : null,
        'notes'          => $faker->paragraph,
    ];
});
