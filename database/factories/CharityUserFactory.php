<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Charity;
use App\Models\CharityUser;
use Faker\Generator as Faker;

$factory->define(CharityUser::class, function (Faker $faker, $options) {

    $charity = array_key_exists('charity_id', $options)
        ? Charity::find($options['charity_id'])
        : factory(Charity::class)->create();

    $user = array_key_exists('user_id', $options)
        ? User::find($options['user_id'])
        : factory(User::class)->create();

    return [
        'charity_id' => $charity->id,
        'user_id'    => $user->id,
    ];
});
