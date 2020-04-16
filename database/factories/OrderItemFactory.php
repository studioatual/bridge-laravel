<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    $product = Product::inRandomOrder()->first();
    return [
        'order_id' => Order::inRandomOrder()->first()->id,
        'product_id' => $product->id,
        'quantity' => rand(1, 4),
        'price' => $product->price,
    ];
});
