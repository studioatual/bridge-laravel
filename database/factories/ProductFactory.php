<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->text(80),
        'price' => $faker->randomFloat(2, 40, 999),
        'active' => $faker->boolean(rand(0, 100)),
    ];
});
