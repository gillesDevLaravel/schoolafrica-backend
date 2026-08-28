<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SalaryDeduction;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SalaryDeduction::class, function (Faker $faker) {
    return [
        'idUser' => User::inRandomOrder()->first()->id,
        'idUserApprove' => User::inRandomOrder()->first()->id,
        'amount' => $faker->randomNumber(),
        'reason' => $faker->word,
        'date' => $faker->dateTimeThisYear($max = 'now', $timezone = null),
        'created_by' => User::inRandomOrder()->first()->id,
        'deleted' => 0
    ];
});
