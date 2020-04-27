<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $cpfCnpj = rand(0, 100) > 50 ? $faker->cnpj(false) : $faker->cpf(false);
    return [
        'group_id' => Group::inRandomOrder()->first()->id,
        'name' => $faker->name,
        'cpf_cnpj' => $cpfCnpj,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('123456'),
        'hash' => Str::random(20),
    ];
});
