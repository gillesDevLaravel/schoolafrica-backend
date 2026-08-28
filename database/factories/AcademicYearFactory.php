<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(\App\Models\AcademicYear::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'start_date' => $faker->date,
        'end_date' => $faker->date,
        'created_by' => User::inRandomOrder()->first()->id,
        'deleted' => 0
    ];
});
