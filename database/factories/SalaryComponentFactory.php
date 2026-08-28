<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SalaryComponent;
use Faker\Generator as Faker;

$factory->define(SalaryComponent::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'order' => $faker->randomNumber(2),
        'type' => $this->faker->randomElement(['prime', 'indemnité', 'bonus', 'allocation']),
        'code' => $this->faker->word,
        'created_by' => null,
        'deleted' => 0,
    ];
});
