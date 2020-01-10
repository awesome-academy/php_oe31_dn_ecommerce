<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\User;
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
    return [
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'gender' => rand(User::MALE, User::FE_MALE),
        'birthdate' => $faker->dateTime($timeZone = null),
        'address' => $faker->address,
        'city_id' => rand(1,63),
        'role_id' => 3, //user
        'remember_token' => Str::random(10),
    ];
});
