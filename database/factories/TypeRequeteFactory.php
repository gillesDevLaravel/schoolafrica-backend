<?php

/** @var Factory $factory */

use App\Models\TypeRequete;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(TypeRequete::class, function (Faker $faker) {
    return [
        'name'       => $faker->word(),
        'created_by' => User::inRandomOrder()->first()->id ?? null,
    ];
});
