<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Control;
use Faker\Generator as Faker;

$factory->define(Control::class, function (Faker $faker) {
    return [
        'type' => 'Mobile',
        'count' => 0,
    ];
});
