<?php

use Faker\Generator as Faker;
use App\Models\Product;

$arr_price = [
    120000,
    150000,
    180000,
    190000,
    200000,
    250000,
    270000,
    290000,
    300000,
    310000,
    330000,
    340000,
    360000,
    370000,
    380000,
    390000,
    400000,
    420000,
    440000,
    450000,
    470000,
    480000,
    490000,
    495000,
    500000
];
$factory->define(Product::class, function (Faker $faker) use ($arr_price) {
    return [
        'name' => $faker->text($maxNbChars = 40),
        'description' => $faker->text($maxNbChars = 150),
        'price' => $arr_price[rand(0, 24)],
        'quantity' => rand(0, 30),
        'category_id' => rand(4, 20),
    ];
});
