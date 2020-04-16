<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'name' => $faker->company,
        'cnpj' => $faker->unique()->cnpj(false),
        'email' => $faker->unique()->safeEmail(),
        'active' => $faker->boolean(rand(0, 100)),
    ];
});
