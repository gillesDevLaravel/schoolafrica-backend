<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $types = ['consommable', 'stockable'];

    return [
        'name' => $faker->name,
        'description' => $faker->sentence(),
        'price' => $faker->randomNumber(3),
        'type' => rand(0, count($types)-1),
        'created_by' => rand(1, \App\Models\User::count()),
        'deleted' => 0
    ];
});
