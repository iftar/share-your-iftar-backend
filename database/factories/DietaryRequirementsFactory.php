<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DietaryRequirements;
use Faker\Generator as Faker;

$factory->define(DietaryRequirements::class, function (Faker $faker) {
    return [
        "name" => "halal"
    ];
});
