<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Warning::class, function (Faker $faker) {
    return [
        'idUser' => \App\Models\User::inRandomOrder()->first()->id,
        'reason' => $faker->word,
        'date' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'created_by' => \App\Models\User::inRandomOrder()->first()->id,
        'deleted' => 0
    ];
});
