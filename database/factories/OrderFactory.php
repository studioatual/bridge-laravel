<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\Customer;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::inRandomOrder()->first()->id,
        'user_id' => User::inRandomOrder()->first()->id,
        'total' => $faker->randomFloat(2, 40, 999),
    ];
});
