<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'code' => $faker->unique()->randomNumber(2),
        'cnpj' => $faker->unique()->cnpj(false),
        'type' => $faker->boolean(rand(0, 100)),
        'active' => $faker->boolean(rand(0, 100)),
    ];
});
