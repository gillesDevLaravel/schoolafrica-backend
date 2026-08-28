<?php

/** @var Factory $factory */

use App\Enums\BudgetTypeEnum;
use App\Models\Budget;
use App\Models\School;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Budget::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'type' => $faker->randomElement(BudgetTypeEnum::values()),
        'description' => $faker->sentence, // ou $faker->words(3, true)
        'realisation' => $faker->randomFloat(2, 0, 100), // 2 décimales, entre 0 et 100
        'school_id' => School::inRandomOrder()->first()->id,
        'created_by' => auth()->id(),
    ];
});
