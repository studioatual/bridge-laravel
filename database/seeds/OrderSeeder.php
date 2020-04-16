<?php

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 50)->create()->each(function ($order) {
            factory(OrderItem::class, rand(1, 10))->create([
                'order_id' => $order,
            ]);
        });
    }
}
