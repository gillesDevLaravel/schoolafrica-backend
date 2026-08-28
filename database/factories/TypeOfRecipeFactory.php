<?php

/** @var Factory $factory */

use App\Models\School;
use App\Models\TypeOfRecipe;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(TypeOfRecipe::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'code' => strtoupper($faker->bothify('???####')),
        'category' => $faker->word(),
        'school_id' => School::inRandomOrder()->first(),
        'created_by' => auth()->id()
    ];
});
