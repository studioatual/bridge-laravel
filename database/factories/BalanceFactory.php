<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Balance;
use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Balance::class, function (Faker $faker) {
    return [
        'company_id' => Company::inRandomOrder()->first()->id,
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'type' => $faker->boolean(rand(0, 100)),
        'value' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1000, $max = 1000000),
    ];
});
