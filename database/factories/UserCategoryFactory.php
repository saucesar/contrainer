<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\UserCategory;

$factory->define(UserCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'ram_limit' => $faker->numberBetween(100, 2000),
        'storage_limit' => $faker->numberBetween(100, 2000),
    ];
});
