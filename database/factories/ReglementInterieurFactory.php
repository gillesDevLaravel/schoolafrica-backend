<?php

use App\Models\ReglementInterieur;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(ReglementInterieur::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->paragraph(3),
        'type' => $faker->randomElement(['general', 'discipline', 'pedagogie', 'securite']),
        'image' => $faker->optional()->imageUrl(),
        'idSchool' => 1, // À adapter selon votre école
        'idSection' => $faker->optional()->numberBetween(1, 10),
        'created_by' => User::inRandomOrder()->first()->id ?? factory(User::class),
    ];
});
