<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\User;
use App\Models\Order;
use Faker\Generator as Faker;
use App\Models\CollectionPoint;
use App\Models\CollectionPointTimeSlot;

$factory->define(Order::class, function (Faker $faker, $options) {
    $faker = Factory::create('en_GB');

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->create();

    $collectionPoint = array_key_exists('collection_point_id', $options)
        ? CollectionPoint::find($options['collection_point_id'])
        : factory(CollectionPoint::class)->create();

    $collectionPointTimeSlot = array_key_exists('collection_point_time_slot_id', $options)
        ? CollectionPointTimeSlot::find($options['collection_point_time_slot_id'])
        : factory(CollectionPointTimeSlot::class)->create();

    return [
        'user_id'                       => $user->id,
        'required_date'                 => $faker->dateTimeBetween('+1 day', '+7 days'),
        'quantity'                      => rand(0, 5),
        'collection_point_id'           => $collectionPoint->id,
        'collection_point_time_slot_id' => $collectionPointTimeSlot->id,
        'first_name'                    => $faker->firstName,
        'last_name'                     => $faker->lastName,
        'email'                         => customEmail(),
        'phone'                         => null,
        'address_line_1'                => null,
        'address_line_2'                => null,
        'town'                          => null,
        'county'                        => null,
        'post_code'                     => null,
        'notes'                         => null,
    ];
});

$factory->state(Order::class, 'delivery', function ($faker, $options) {
    $faker = Factory::create('en_GB');

    return [
        'collection_point_time_slot_id' => null,
        'phone'                         => $faker->e164PhoneNumber,
        'address_line_1'                => $faker->streetAddress,
        'address_line_2'                => $faker->streetName,
        'city'                          => $faker->city,
        'county'                        => $faker->county,
        'post_code'                     => $faker->postcode,
    ];
});

function customEmail()
{
    $faker = Factory::create('en_GB');

    return strtolower(
        "$faker->firstName.$faker->firstName.$faker->lastName" . $faker->numberBetween(1, 1000) . "@$faker->domainName"
    );
}
