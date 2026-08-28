<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\StatusEnum;
use App\Models\Bonus;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Bonus::class, function (Faker $faker) {
    return [
        'idUser' => User::inRandomOrder()->first()->id,
        'idUserApprove' => User::inRandomOrder()->first()->id,
        'reason' => $this->faker->text,
        'amount' => rand(1000, 1000),
        'bonus_type' => $this->faker->randomElement(['student', 'staff']),
        'deleted' => 0,
        'is_used' => $this->faker->boolean,
        'status' =>  $this->faker->randomElement(StatusEnum::values()),
    ];
});
