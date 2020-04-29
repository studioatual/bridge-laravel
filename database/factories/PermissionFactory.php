<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->randomNumber(4),
        'name' => strtoupper(str_replace(" ", "", $faker->sentence($nbWords = 2, $variableNbWords = true))),
        'description' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'active' => $faker->boolean(rand(0, 100)),
    ];
});
