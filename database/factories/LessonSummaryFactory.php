<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lesson;
use App\Models\LessonSummary;
use Faker\Generator as Faker;

$factory->define(LessonSummary::class, function (Faker $faker) {
    return [
        'idLesson' => Lesson::all()->random()->id,
        'description' => $faker->text,
        'date' => $faker->date,
        'deleted' => 0,
    ];
});
