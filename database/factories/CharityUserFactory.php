<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CharityUser;
use Faker\Generator as Faker;

$factory->define(CharityUser::class, function (Faker $faker, $charity_id, $user_id) {
    return [
        'charity_id' => $charity_id,
        'user_id' => $user_id,
    ];
});
