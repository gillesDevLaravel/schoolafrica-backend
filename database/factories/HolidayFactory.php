<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Holiday;
use Faker\Generator as Faker;

$factory->define(Holiday::class, function (Faker $faker) {
    $types = ['maladie', 'congé', 'repos'];

    return [
        'idUser' => \App\Models\User::inRandomOrder()->first()->id,
        'idUserApprove' => \App\Models\User::inRandomOrder()->first()->id,
        'reason' => $this->faker->text,
        'type' => $this->faker->randomElement($types),
        'days_taken' => rand(1, 3),
        'start_date' => $this->faker->date,
        'end_date' => $this->faker->date,
        'deleted' => 0,
    ];
});
