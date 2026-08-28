<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SchoolDelay;
use App\Models\User;
use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(SchoolDelay::class, function (Faker $faker) {
    return [
        'hour'        => $faker->time('H:i'),
        'date'        => $faker->date(),
        'description' => $faker->optional()->sentence,
        'idStudent'   => function () {
            return factory(User::class)->create()->id;
            // 'idCourse'    => function () {
//            return factory(Course::class)->create()->id;
        },
        'created_by'  => function () {
            return factory(User::class)->create()->id;
        },
        'updated_by'  => function () {
            return factory(User::class)->create()->id;
        },
        'deleted_by'  => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
