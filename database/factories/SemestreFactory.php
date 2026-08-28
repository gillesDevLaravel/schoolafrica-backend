<?php

/** @var Factory $factory */

use App\Models\Semestre;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Semestre::class, function (Faker $faker) {
    return [
        'name'                 => $faker->word,
        'created_by'           => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
