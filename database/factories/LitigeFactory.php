<?php

use App\Models\Litige;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Litige::class, function (Faker $faker) {
    return [
        'name'       => $faker->sentence(3),
        'description' => $faker->paragraph,
        'answer'  => $faker->optional()->sentence,
        'user_id'  => User::inRandomOrder()->first()->id ?? factory(User::class),
        'created_by'  => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
