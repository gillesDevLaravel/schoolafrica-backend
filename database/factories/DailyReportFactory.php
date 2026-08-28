<?php

/** @var Factory $factory */

use App\Models\DailyReport;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(DailyReport::class, function (Faker $faker) {

    return [
        'user_id'         => function () {
            return factory(User::class)->create()->id;
        },
        'name'            => $faker->sentence,
        'description'     => $faker->sentence,
        'comments'        => $faker->paragraph,
        'date'            => $faker->dateTimeBetween('-10 days', 'now'),
        'created_by'      => function () {
            return auth()->id() ?? factory(User::class)->create()->id;
        },
    ];
});
