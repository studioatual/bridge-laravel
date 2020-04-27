<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use App\Models\Group;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'group_id' => Group::inRandomOrder()->first()->id,
        'company' => $faker->company,
        'name' => $faker->name,
        'cnpj' => $faker->cnpj(false),
        'code' => $faker->unique()->randomNumber(2)
    ];
});
