<?php

/** @var Factory $factory */

use App\Models\DailyReport;
use App\Models\Suggestion;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Suggestion::class, function (Faker $faker) {

    return [
        'user_id'         => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->name,
        'is_anonymous' => $faker->boolean,
        'description'     => $faker->sentence,
    ];
});
