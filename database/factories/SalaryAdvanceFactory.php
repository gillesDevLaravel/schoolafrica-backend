<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\StatusEnum;
use App\Models\SalaryAdvance;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SalaryAdvance::class, function (Faker $faker) {
    return [
        'idUser' => User::inRandomOrder()->first()->id,
        'idUserApprove' => User::inRandomOrder()->first()->id,
        'amount' => $faker->randomFloat(2, 10, 100),
        'status' => $faker->randomElement(StatusEnum::values()),
        'reason' => $faker->text,
        'approval_date' => null,
        'comments' => null,
        'deleted' => 0,
        'updated_by' => null,
        'deleted_by' => null,
    ];
});
