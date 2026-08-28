<?php

use App\Models\ExplanationRequest;
use App\Models\School;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(ExplanationRequest::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'idUser' => User::inRandomOrder()->first()->id ?? factory(User::class),
        'idResponsable' => User::inRandomOrder()->first()->id ?? factory(User::class),
        'image' => $faker->optional()->imageUrl(),
        'comments' => $faker->optional()->sentence,
        'created_by' => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
