<?php

use App\Models\SchoolExam;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SchoolExam::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'description' => $faker->text,
        'idMatter' => $faker->numberBetween(1, 10),
        'idAssessmentType' => $faker->numberBetween(1, 5),
        'created_by' => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
